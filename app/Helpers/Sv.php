<?php

namespace App\Helpers;

class Sv
{
    public static function idr_format($number)
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }
}
