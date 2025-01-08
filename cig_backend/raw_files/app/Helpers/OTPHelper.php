<?php

namespace App\Helpers;

class OtpHelper
{
    /**
     * Generate a 6-digit OTP.
     *
     * @return string
     */
    public static function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
