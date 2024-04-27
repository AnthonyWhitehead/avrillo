<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface QuoteDriver
{
    public function getQuotes(): Collection;

    public function refreshQuotes(): Collection;
}