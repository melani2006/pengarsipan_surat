<?php

namespace App\Enums;

enum Config
{
    case password;
    case PAGE_SIZE;
    case nama_aplikasi;
    case nama_institusi;
    case alamat_institusi;
    case telepon_institusi;
    case email_institusi;
    case penanggung_jawab;

    public function value(): string
    {
        return match ($this) {
            self::password => 'password',
            self::PAGE_SIZE => 'page_size',
            self::nama_aplikasi => 'nama_aplikasi',
            self::nama_institusi => 'nama_institusi',
            self::alamat_institusi => 'alamat_institusi',
            self::telepon_institusi => 'telepon_institusi',
            self::email_institusi => 'email_institusi',
            self::penanggung_jawab => 'penanggung_jawab',
        };
    }
}
