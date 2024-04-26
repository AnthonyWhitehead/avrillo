<?php

namespace App\Services;

use App\Models\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TokenService
{
    /**
     * Create a token.
     *
     * @return Token
     */
    public function createToken(): Token
    {
        return Token::create([
            'value' => $this->encryptValue(Str::random(60)),
            'expires_at' => Carbon::now()->addMinutes((int)config('tokens.expiry')),
        ]);
    }

    /**
     * Encrypt a value
     *
     * @param string $value
     * @return string
     */
    private function encryptValue(string $value): string
    {
        return openssl_encrypt(
            data: $value,
            cipher_algo: config('tokens.cipher'),
            passphrase: config('tokens.passphrase'),
            iv: config('tokens.secret'),
        );
    }
}