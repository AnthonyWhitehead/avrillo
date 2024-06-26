<?php

namespace App\Traits;

trait OpenSslTrait
{
    /**
     * Encrypt data using OpenSSL.
     *
     * @param string $data
     * @param string $cipher
     * @return string
     */
    public function openSslEncrypt(string $data, string $cipher): string
    {
        $tag = $data;

        return base64_encode(openssl_encrypt(
            data: $data,
            cipher_algo: $cipher,
            passphrase: config('tokens.passphrase'),
            iv: config('tokens.secret'),
            tag: $tag,
        ));
    }
}