<?php

namespace App\Drivers\Quotes;

use App\Interfaces\QuoteDriver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KanyeDriver implements QuoteDriver
{
    /**
     * Get quotes
     *
     * @return Collection
     */
    public function getQuotes(): Collection
    {
        return Cache::remember(
            'kanye.quotes',
            now()->addHour(),
            fn() => $this->generateQuoteCollection()
        );
    }

    /**
     * Refresh the quotes
     *
     * @return Collection
     */
    public function refreshQuotes(): Collection
    {
        Cache::forget('kanye.quotes');
        return $this->getQuotes();
    }

    /**
     * Generate a quote array by consuming the Kanye rest API
     *
     * @return Collection
     */
    private function generateQuoteCollection(): Collection
    {
        for ($i = 0; $i < 5; $i++) {
            $response = Http::get('https://api.kanye.rest')->json();
            $quotes[] = $response['quote'];
        }

        return collect($quotes);
    }
}