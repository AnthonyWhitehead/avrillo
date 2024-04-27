<?php

namespace App\Managers;

use App\Drivers\Quotes\InspirationalDriver;
use App\Drivers\Quotes\KanyeDriver;
use App\Interfaces\QuoteManagerInterface;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Manager;

class QuoteManager extends Manager implements QuoteManagerInterface
{
    /**
     * Get the default driver
     *
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed|string
     */
    public function getDefaultDriver(): mixed
    {
        return config('quotes.driver', 'kanye');
    }

    /**
     * Get the Kanye driver
     *
     * @return KanyeDriver
     */
    public function createKanyeDriver(): KanyeDriver
    {
        return new KanyeDriver();
    }

    /**
     * Get the Inspirational driver
     *
     * @return InspirationalDriver
     */
    public function createInspirationalDriver(): InspirationalDriver
    {
        return new InspirationalDriver();
    }
}