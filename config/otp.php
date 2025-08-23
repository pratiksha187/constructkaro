<?php

return [
    'length' => (int) env('OTP_CODE_LENGTH', 6),
    'expires_minutes' => (int) env('OTP_EXPIRES_MINUTES', 10),
    'resend_cooldown_seconds' => (int) env('OTP_RESEND_COOLDOWN_SECONDS', 45),
    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),
];
