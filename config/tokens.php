<?php

return [
    'expiry' => env('TOKEN_EXPIRY', 60),
    'cipher' => 'aes-256-cbc',
    'passphrase' => env('PASSPHRASE'),
    'secret' => env('SECRET'),
];