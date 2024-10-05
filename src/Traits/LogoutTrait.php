<?php

namespace Intrazero\AuthBoilerplate\Traits;

use Illuminate\Http\Request;
use Intrazero\AuthBoilerplate\Services\AuthenticationManager;

trait LogoutTrait
{
    /**
     * Handle user logout by revoking the token.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Intrazero\AuthBoilerplate\Services\AuthenticationManager $authManager
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request, AuthenticationManager $authManager)
    {
        $user = $request->user();
        $authManager->revokeToken($user);

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
