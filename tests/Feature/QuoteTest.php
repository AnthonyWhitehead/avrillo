<?php

namespace Tests\Feature;

use App\Facades\QuoteFacade;
use App\Models\Token;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_quotes(): void
    {
        $token = Token::factory()->create();

        // mock kanye api request
        Http::fake(function () use (&$quotes) {
            $quote = fake()->word;
            $quotes[] = $quote;
            return Http::response([
                'quote' => $quote,
            ]);
        });

        // Assert token needed
        $this->get(route('api.quotes.index'))->assertUnauthorized();

        $response = $this->withHeader('token', $token->value)->get(route('api.quotes.index'));

        // Assert ok with token
        $response->assertOk();

        $response->assertJson(fn(AssertableJson $json) => $json->has('data')
            ->has('data', 5)
            ->where('data', $quotes)
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_refresh_quotes(): void
    {
        $token = Token::factory()->create();

        Http::fake(function () use (&$quotes) {
            $quote = fake()->word;
            $quotes[] = $quote;
            return Http::response([
                'quote' => $quote,
            ]);
        });

        // Generate old quotes
        $oldQuotes = collect();

        for ($i = 0; $i < 5; $i++) {
            $oldQuotes->push(fake()->word);
        }

        Cache::remember(
            'quotes',
            now()->addHour(),
            fn() => $oldQuotes
        );

        // Assert old quotes are cached
        $this->assertEquals($oldQuotes, QuoteFacade::getQuotes());

        // Assert token needed
        $this->getJson(route('api.quotes.refresh'))->assertUnauthorized();

        $response = $this->withHeader('token', $token->value)->get(route('api.quotes.refresh'));

        // Assert ok with token
        $response->assertOk();

        $response->assertJson(fn(AssertableJson $json) => $json->has('data')
            ->has('data', 5)
            ->where('data', $quotes)
        );
    }
}