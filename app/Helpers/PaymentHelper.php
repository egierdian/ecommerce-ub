<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('paymentStatus')) {
    function paymentStatus($status = null)
    {
        $mapping = [
            1 => 'Order Created',
            2 => 'Paid',
            3 => 'Failed/Rejected',
            4 => 'Cancelled',
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

        $badge = 'bg';
        if (Auth::check()) {
            if(Auth::user()->role != 'customer') $badge = 'badge';
        }
        return '<span class="badge '.$badge.'-' . $color . '">' . $label . '</span>';
    }
}
