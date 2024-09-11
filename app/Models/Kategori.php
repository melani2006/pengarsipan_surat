<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'deskripsi',
    ];

    /**
     * Scope untuk mencari klasifikasi berdasarkan kriteria pencarian.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('type', 'LIKE', $find . '%')
                ->orWhere('code', $find);
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
            ->search($search)
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }
}
