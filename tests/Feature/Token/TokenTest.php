<?php

namespace Tests\Feature\Token;

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
        $response = $this->get(route('api.token.create'));

        $response->assertCreated();

        $response->assertJson(fn(AssertableJson $json) => $json->has('data')
            ->has('data.token')
            ->has('data.expires_at')
            ->where('data.expires_at', Carbon::now()->addMinutes((int)config('tokens.expiry'))->toDateTimeString())
        );
    }
}