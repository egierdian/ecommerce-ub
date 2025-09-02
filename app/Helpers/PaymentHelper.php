<?php

if (!function_exists('paymentStatus')) {
    function paymentStatus($status = null)
    {
        $mapping = [
            1 => 'Pesanan Dibuat',   
            2 => 'Lunas',        
            3 => 'Gagal/Ditolak',     
            4 => 'Dibatalkan',   
        ];

        if ($status === null) {
            return $mapping; // return semua mapping kalau tidak ada parameter
        }

        return $mapping[$status] ?? 'Unknown';
    }
}

if (!function_exists('paymentStatusBadge')) {
    function paymentStatusBadge($status)
    {
        $badges = [
            1 => 'secondary', // abu
            2 => 'success',   // hijau
            3 => 'danger',    // merah
            4 => 'dark',      // hitam/abu
        ];

        $label = paymentStatus($status);
        $color = $badges[$status] ?? 'secondary';

        return '<span class="badge bg-' . $color . '">' . $label . '</span>';
    }
}
