<?php

namespace App\Http\Controllers;

use App\Facades\TokenFacade;
use App\Http\Requests\CreateTokenRequest;
use App\Http\Resources\TokenResource;

class TokenController extends Controller
{
    /**
     * Create a token.
     */
    public function create(CreateTokenRequest $request): TokenResource
    {
        return new TokenResource(TokenFacade::createToken());
    }
}