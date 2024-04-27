<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TokenTest extends TestCase
{
    /**
     * Test token creation
     */
    public function test_create_token(): void
    {
        // Assert invalid with incorrect passphrase and secret
        $this->postJson(route('api.token.create', [
            'passphrase' => fake()->word,
            'secret' => fake()->word,
        ]))->assertInvalid([
            'passphrase',
            'secret',
        ]);

        $response = $this->postJson(route('api.token.create', [
            'passphrase' => config('tokens.passphrase'),
            'secret' => config('tokens.secret'),
        ]))->assertValid();

        $response->assertJson(fn(AssertableJson $json) => $json->has('data')
            ->has('data.token')
            ->has('data.expires_at')
            ->where('data.expires_at', Carbon::now()->addMinutes((int)config('tokens.expiry'))->toDateTimeString())
        );
    }
}