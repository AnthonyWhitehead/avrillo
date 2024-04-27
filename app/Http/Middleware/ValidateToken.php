<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // No token in the header
        if (!$this->hasTokenInHeader(request: $request)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // No token in the database
        if (!$this->hasTokenInDatabase(request: $request)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Token has expired
        if ($this->hasTokenExpired(token: $this->hasTokenInDatabase(request: $request))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    /**
     * Is there a token in the header?
     *
     * @param Request $request
     * @return bool
     */
    protected function hasTokenInHeader(Request $request): bool
    {
        return $request->hasHeader('token');
    }

    /**
     * Is there a token in the database?
     *
     * @param Request $request
     * @return Token|null
     */
    private function hasTokenInDatabase(Request $request): ?Token
    {
        return Token::where('value', $request->header('token'))->first();
    }

    /**
     * Has the token expired?
     *
     * @param Token $token
     * @return bool
     */
    private function hasTokenExpired(Token $token): bool
    {
        return $token->expires_at < Carbon::now();
    }
}
