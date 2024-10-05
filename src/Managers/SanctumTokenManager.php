<?php

namespace Intrazero\AuthBoilerplate\Managers;

use Intrazero\AuthBoilerplate\Contracts\TokenManagerInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class SanctumTokenManager implements TokenManagerInterface
{
    /**
     * Generate a Sanctum token for the user and return user data.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return array
     */
    public function createToken(Authenticatable $user): array
    {

        $loginField = config('authentication.login_field', 'email');
        // Generate the token using Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        // Return an array with token and user data
        return [
            'access_token' => $token,
            'token_type' => 'Bearer', // Common for API tokens
            'user' => [
                'id' => $user->id,
                $loginField  => $user->$loginField ,
                // Add additional user fields if needed
            ],
        ];
    }

    /**
     * Revoke the Sanctum token for the user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function revokeToken(Authenticatable $user): void
    {
        // Revoke (delete) all of the user's tokens
        $user->tokens()->delete();
    }

    /**
     * Return an error for refresh token, as Sanctum does not support refresh tokens.
     *
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        // Return an error or throw an exception since Sanctum does not support refresh tokens
        return ['error' => 'Sanctum does not support refresh tokens'];
    }
}
