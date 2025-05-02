<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();


        if (!$token) {

            return response()->json([
                'success' => false,
                'message' => 'Access token not provided.',
            ], 401);
        }

        // Using the 'api' guard (configured for Passport), attempt to retrieve the user
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired access token.',
            ], 401);
        }

        // Optionally, you could also attach the user to the request here
        $request->merge(['user' => $user]);

        return $next($request);
    }
}
