<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');
        $result = JWTToken::verifyToken($token);
        if ($result == 'unauthorized') {
            return response()->json(['message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }
        $request->headers->set('email', $result);
        return $next($request);

    }
}
