<?php

namespace App\Http\Controllers;

use App\Facades\QuoteFacade;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    public function index(): QuoteResource
    {
        return new QuoteResource(QuoteFacade::getQuotes());
    }

    public function refresh(): QuoteResource
    {
        return new QuoteResource(QuoteFacade::refreshQuotes());
    }
}