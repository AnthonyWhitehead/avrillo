<?php

return [
    'expiry' => env('TOKEN_EXPIRY', 60),
    'driver' => 'cbc',
    'passphrase' => env('PASSPHRASE'),
    'secret' => env('SECRET'),
];