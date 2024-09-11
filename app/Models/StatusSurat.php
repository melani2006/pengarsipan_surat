<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    /**
     * Scope untuk mencari status surat berdasarkan kata kunci.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('status', 'LIKE', $find . '%');
        });
    }

    /**
     * Scope untuk merender daftar status surat dengan pencarian.
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
