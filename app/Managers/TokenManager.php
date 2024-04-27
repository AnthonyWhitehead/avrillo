<?php

namespace App\Managers;

use App\Drivers\Tokens\CbcDriver;
use App\Drivers\Tokens\GcmDriver;
use App\Interfaces\TokenManagerInterface;
use Illuminate\Support\Manager;

class TokenManager extends Manager implements TokenManagerInterface
{
    public function createCbcDriver(): CbcDriver
    {
        return new CbcDriver();
    }

    public function createGcmDriver(): GcmDriver
    {
        return new GcmDriver();
    }

    public function getDefaultDriver()
    {
        return config('tokens.driver', 'cbc');
    }
}