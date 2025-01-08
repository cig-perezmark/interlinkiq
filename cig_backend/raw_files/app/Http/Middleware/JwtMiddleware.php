<?php
namespace App\Http\MiddleWare;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Helpers\CustomUser;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Try to parse the JWT token and authenticate the user using CustomUser
            $user = JWTAuth::parseToken();
            $payload = JWTAuth::getPayload($user);

            // Retrieve specific data from the payload
            $request->merge([
                'user_id' => $payload->get('sub'),
                'user_permissions' => $payload->get('user_permissions'),
            ]);

        } catch (Exception $e) {
            // Handle specific token exceptions
            if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token has expired',
                    'code' => 401
                ], 401);
            } elseif ($e instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is invalid',
                    'code' => 401
                ], 401);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token not found',
                    'code' => 401
                ], 401);
            }
        }

        return $next($request);
    }
}
