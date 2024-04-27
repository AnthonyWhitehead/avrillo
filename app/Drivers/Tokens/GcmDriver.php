<?php

namespace App\Drivers\Tokens;

use App\Interfaces\TokenDriver;
use App\Models\Token;
use App\Traits\OpenSslTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GcmDriver implements TokenDriver
{
    use OpenSslTrait;

    /**
     * Create a token.
     *
     * @return Token
     */
    public function createToken(): Token
    {
        return Token::create([
            'value' => $this->openSslEncrypt(data: Str::random(60), cipher: 'aes-256-gcm'),
            'expires_at' => Carbon::now()->addMinutes((int)config('tokens.expiry')),
        ]);
    }
}