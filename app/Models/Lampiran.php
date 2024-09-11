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
        'extension',
        'surat_id',
        'user_id',
    ];

    protected $appends = [
        'path_url',
    ];

    /**
     * Mendapatkan URL path untuk lampiran.
     *
     * @return string
     */
    public function getPathUrlAttribute(): string {
        if (!is_null($this->path)) {
            return $this->path;
        }

        return asset('storage/attachments/' . $this->filename);
    }

    /**
     * Scope untuk memfilter berdasarkan tipe surat.
     *
     * @param $query
     * @param LetterType $type
     * @return mixed
     */
    public function scopeType($query, LetterType $type)
    {
        return $query->whereHas('surat', function ($query) use ($type) {
            return $query->where('type', $type->type());
        });
    }

    /**
     * Scope untuk memfilter surat masuk.
     *
     * @param $query
     * @return mixed
     */
    public function scopeMasuk($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    /**
     * Scope untuk memfilter surat keluar.
     *
     * @param $query
     * @return mixed
     */
    public function scopeKeluar($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
    }

    /**
     * Scope untuk mencari lampiran berdasarkan kriteria pencarian.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('filename', 'LIKE', '%' . $find . '%')
                ->orWhereHas('surat', function ($query) use ($find) {
                    return $query->where('reference_number', $find);
                });
        });
    }

    /**
     * Scope untuk merender hasil pencarian dengan paginasi.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
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
     * Relasi ke model Surat.
     *
     * @return BelongsTo
     */
    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }

    /**
     * Relasi ke model User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
