<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatHelper
{
    /**
     * Format Rupiah
     *
     * @param int|float $number
     * @return string
     */
    public static function rupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    /**
     * Format Tanggal Indonesia
     *
     * @param string|Carbon $date
     * @param bool $withTime
     * @return string
     */
    public static function tanggalIndo($date, $withTime = false)
    {
        if (!$date) return '-';

        $carbonDate = $date instanceof Carbon ? $date : Carbon::parse($date);
        
        // Atur locale ke Indonesia
        $carbonDate->locale('id');
        
        $format = 'd F Y';
        if ($withTime) {
            $format = 'd F Y H:i';
        }

        return $carbonDate->translatedFormat($format);
    }

    /**
     * Generator Kode Unik untuk NISN / NIP
     * Format: TAHUN + BULAN + URUTAN
     * Contoh: 202605001
     *
     * @param string $prefix (opsional, misalnya 'G' untuk Guru, 'M' untuk Murid)
     * @param int $lastId ID terakhir untuk generate nomor urut
     * @return string
     */
    public static function generateKode($prefix = '', $lastId = 0)
    {
        $yearMonth = date('Ym');
        $sequence = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $yearMonth . $sequence;
    }
}
