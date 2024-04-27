<?php

namespace App\Managers;

use App\Drivers\Quotes\KanyeDriver;
use App\Interfaces\QuoteManagerInterface;
use Illuminate\Support\Manager;

class QuoteManager extends Manager implements QuoteManagerInterface
{
    public function getDefaultDriver()
    {
        return config('quotes.driver', 'kanye');
    }

    public function createKanyeDriver(): KanyeDriver
    {
        return new KanyeDriver();
    }
}