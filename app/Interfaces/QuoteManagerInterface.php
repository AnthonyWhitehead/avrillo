<?php

namespace App\Interfaces;

use App\Drivers\Quotes\KanyeDriver;

interface QuoteManagerInterface
{
    public function createKanyeDriver(): KanyeDriver;
}