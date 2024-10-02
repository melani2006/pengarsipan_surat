<?php

namespace App\Models;

use App\Enums\SuratType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'filename',
        'extension',
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

    public function scopeType($query, SuratType $type)
    {
        return $query->whereHas('surat', function ($query) use ($type) {
            return $query->where('type', $type->type());
        });
    }

    public function scopeMasuk($query)
    {
        return $this->scopeType($query, SuratType::MASUK);
    }

    public function scopeKeluar($query)
    {
        return $this->scopeType($query, SuratType::KELUAR);
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
            ->paginate(10)
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