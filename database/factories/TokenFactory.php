<?php

namespace Database\Factories;

use App\Traits\OpenSslTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\token>
 */
class TokenFactory extends Factory
{
    use OpenSslTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->openSslEncrypt(data: Str::random(), cipher: 'aes-256-cbc'),
            'expires_at' => now()->addMinutes((int)config('tokens.expiry')),
        ];
    }
}
