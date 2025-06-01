<?php

namespace App\Helpers;

class RupiahHelper
{
    public static function rupiah($angka)
    {
        return 'Rp' . number_format($angka, 0, ',', '.');
    }
}
