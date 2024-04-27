<?php

namespace App\Interfaces;

use App\Drivers\Quotes\InspirationalDriver;
use App\Drivers\Quotes\KanyeDriver;

interface QuoteManagerInterface
{
    public function createKanyeDriver(): KanyeDriver;

    public function createInspirationalDriver(): InspirationalDriver;
}