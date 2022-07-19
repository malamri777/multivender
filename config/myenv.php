<?php

return [

    'MAIL_DRIVER' => env('MAIL_DRIVER', 'smtp'), // sendmail, smtp, mailgun
    'MAIL_HOST' => env('MAIL_HOST', 'http://127.0.0.1'),
    'MAIL_PORT' => env('MAIL_PORT', 8025),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'username'),
    'MAIL_PASSWORD' => env('MAIL_PASSWORD', 'password'),
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'http://127.0.0.1'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'http://127.0.0.1'),
    'MAIL_FROM_NAME' => env('MAIL_FROM_NAME', 'http://127.0.0.1'),
    'MAILGUN_DOMAIN' => env('MAILGUN_DOMAIN', 'http://127.0.0.1'),
    'MAILGUN_SECRET' => env('MAILGUN_SECRET', 'http://127.0.0.1'),

    'OTP_DEBUG_ENABLE' => env('OTP_DEBUG_ENABLE', "on"),  // on or off
    'UNIFONIC_KEY' => env('UNIFONIC_KEY', '1234567890'),
    'UNIFONIC_SECRET' => env('UNIFONIC_SECRET', '1234567890'),
    'DEFAULT_COUNT' => env('DEFAULT_COUNT', 3),
    'DEFAULT_TIME_AMOUNT' => env(' DEFAULT_TIME_AMOUNT', 3),

];
