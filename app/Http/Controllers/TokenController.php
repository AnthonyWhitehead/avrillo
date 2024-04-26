<?php

namespace App\Http\Controllers;

use App\Facades\TokenFacade;
use App\Http\Resources\TokenResource;

class TokenController extends Controller
{
    /**
     * Create a token.
     */
    public function create(): TokenResource
    {
        return new TokenResource(TokenFacade::createToken());
    }
}