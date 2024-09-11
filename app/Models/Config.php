<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'value',
    ];

    /**
     * Mengambil nilai berdasarkan kode konfigurasi.
     *
     * @param \App\Enums\Config $code
     * @return string
     */
    public static function getValueByCode(\App\Enums\Config $code): string
    {
        $config = self::code($code)->first();
        return $config->value;
    }

    /**
     * Scope untuk mencari konfigurasi berdasarkan kode.
     *
     * @param $query
     * @param \App\Enums\Config $code
     * @return mixed
     */
    public function scopeCode($query, \App\Enums\Config $code)
    {
        return $query->where('code', $code->value());
    }
}
