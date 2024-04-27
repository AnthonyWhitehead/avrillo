<?php

namespace App\Facades;

use App\Managers\QuoteManager;
use Illuminate\Support\Facades\Facade;

class QuoteFacade extends Facade
{
    /**
     * @method static string driver(string $driver = null)
     * @method static array getQuotes()
     * @method static array refreshQuotes()
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return QuoteManager::class;
    }
}