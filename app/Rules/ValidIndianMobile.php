<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidIndianMobile implements Rule
{
    public function passes($attribute, $value): bool
    {
        // keep only digits
        $d = preg_replace('/\D+/', '', (string) $value);

        // strip country/leading zero
        if (str_starts_with($d, '91') && strlen($d) === 12) {
            $d = substr($d, -10);
        }
        if (strlen($d) === 11 && $d[0] === '0') {
            $d = substr($d, 1);
        }

        // must be 10 digits, start 6–9
        if (!preg_match('/^[6-9]\d{9}$/', $d)) {
            return false;
        }

        // reject all same digit e.g. 9999999999
        if (preg_match('/^(\d)\1{9}$/', $d)) {
            return false;
        }

        // reject fully sequential ascending / descending
        if (strpos('0123456789', $d) !== false || strpos('9876543210', $d) !== false) {
            return false;
        }

        // reject any run of 5 identical digits
        for ($i = 0; $i <= 5; $i++) {
            $chunk = substr($d, $i, 5);
            if (preg_match('/^(\d)\1{4}$/', $chunk)) {
                return false;
            }
        }

        // (optional) reject simple alternating patterns like 1212121212
        if (preg_match('/^(\d)(\d)\1\2\1\2\1\2\1\2$/', $d)) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Enter a valid Indian mobile number (10 digits, not sequential or repeated).';
    }
}
