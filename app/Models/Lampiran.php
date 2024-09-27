<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use App\Enums\LetterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'filename',
        'ekstensi',
        'surat_id',
        'user_id',
    ];

    protected $appends = [
        'path_url',
    ];

    /**
     * @return string
     */
    public function getPathUrlAttribute(): string {
        if (!is_null($this->path)) {
            return $this->path;
        }

        return asset('storage/lampirans/' . $this->filename);
    }

    public function scopeType($query, LetterType $type)
    {
        return $query->whereHas('surat', function ($query) use ($type) {
            return $query->where('type', $type->type());
        });
    }

    public function scopeIncoming($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    public function scopeOutgoing($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('filename', 'LIKE', '%' . $find . '%')
                ->orWhereHas('surat', function ($query) use ($find) {
                    return $query->where('nomor_surat', $find);
                });
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->with(['surat'])
            ->search($search)
            ->latest('created_at')
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }

    /**
     * @return BelongsTo
     */
    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}