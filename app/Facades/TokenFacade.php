<?php

namespace App\Facades;

use App\Managers\TokenManager;
use Illuminate\Support\Facades\Facade;

class TokenFacade extends Facade
{
    /**
     * @method static string driver(string $driver = null)
     * @method static string createToken()
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TokenManager::class;
    }
}