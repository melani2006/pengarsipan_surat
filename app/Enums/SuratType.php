<?php

namespace App\Enums;

enum SuratType
{
    case INCOMING;
    case OUTGOING;

    public function type(): string
    {
        return match ($this) {
            self::INCOMING => 'masuk',
            self::OUTGOING => 'keluar',
        };
    }
}
