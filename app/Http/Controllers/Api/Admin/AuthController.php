<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $accessToken = $request->input('access_token');
        
       
        if ($accessToken !== config('auth.admin_access_token')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid access token'
            ], 401);
        }

       
        $sessionToken = bin2hex(random_bytes(32));
        
        
        Cache::put(
            'admin_session_' . $sessionToken, 
            true, 
            now()->addSeconds((int) config('auth.access_token_expiry', 3600))
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'access_token' => $sessionToken,
                'refresh_token' => config('auth.admin_refresh_token'),
                'expires_in' => (int) config('auth.access_token_expiry', 3600)
            ]
        ], 200);
    }

    public function refresh(): JsonResponse
    {
        $refreshToken = request()->header('X-Refresh-Token');

        if ($refreshToken !== config('auth.admin_refresh_token')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid refresh token'
            ], 401);
        }

       
        $newSessionToken = bin2hex(random_bytes(32));
        
        Cache::put(
            'admin_session_' . $newSessionToken, 
            true, 
            now()->addSeconds((int) config('auth.access_token_expiry', 3600))
        );

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed',
            'data' => [
                'access_token' => $newSessionToken,
                'expires_in' => (int) config('auth.access_token_expiry', 3600)
            ]
        ], 200);
    }

    public function logout(): JsonResponse
    {
        $token = request()->bearerToken();
        
        if ($token) {
            Cache::forget('admin_session_' . $token);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}