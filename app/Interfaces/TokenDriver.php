<?php

namespace App\Interfaces;

use App\Models\Token;

interface TokenDriver
{
    public function createToken(): Token;
}