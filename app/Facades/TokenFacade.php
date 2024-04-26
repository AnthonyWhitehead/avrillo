<?php

namespace App\Facades;

use App\Services\TokenService;
use Illuminate\Support\Facades\Facade;

class TokenFacade extends Facade
{
    /**
     * @method static string createToken()
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TokenService::class;
    }
}