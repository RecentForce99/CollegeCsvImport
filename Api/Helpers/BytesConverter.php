<?php

namespace Nikitq\Api\Helpers;

class BytesConverter
{
    public static function convert($bytes): string
    {
        $kb = $bytes / 1024;
        $mb = $kb / 1024;
        $gb = $mb / 1024;

        if ($bytes < 1024) {
            return $bytes . ' B'; // Байты
        } elseif ($kb < 1024) {
            return round($kb, 2) . ' KB'; // Килобайты
        } elseif ($mb < 1024) {
            return round($mb, 2) . ' MB'; // Мегабайты
        } else {
            return round($gb, 2) . ' GB'; // Гигабайты
        }
    }
}