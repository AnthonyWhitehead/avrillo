<?php

namespace App\Interfaces;

use App\Drivers\Tokens\CbcDriver;
use App\Drivers\Tokens\GcmDriver;

interface TokenManagerInterface
{
    public function createCbcDriver(): CbcDriver;

    public function createGcmDriver(): GcmDriver;
}