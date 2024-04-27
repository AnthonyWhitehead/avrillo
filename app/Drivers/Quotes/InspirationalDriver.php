<?php

namespace App\Drivers\Quotes;

use App\Interfaces\QuoteDriver;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class InspirationalDriver implements QuoteDriver
{
    /**
     * Get quotes
     *
     * @return Collection
     */
    public function getQuotes(): Collection
    {
        return Cache::remember(
            'quotes',
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
        Cache::forget('quotes');
        return $this->getQuotes();
    }

    /**
     * Generate a quote array by consuming the Kanye rest API
     *
     * @return Collection
     */
    private function generateQuoteCollection(): Collection
    {
        return Inspiring::quotes()->random(5);
    }
}