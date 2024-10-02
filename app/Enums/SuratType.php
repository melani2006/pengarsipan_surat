<?php

namespace App\Enums;

enum SuratType
{
    case MASUK;
    case KELUAR;

    public function type(): string
    {
        return match ($this) {
            self::MASUK => 'masuk',
            self::KELUAR => 'keluar',
        };
    }
}
