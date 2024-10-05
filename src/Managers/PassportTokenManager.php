<?php

namespace Intrazero\AuthBoilerplate\Managers;

use Intrazero\AuthBoilerplate\Contracts\TokenManagerInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class PassportTokenManager implements TokenManagerInterface
{
    /**
     * Generate a Passport token for the user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return array
     */
    public function createToken(Authenticatable $user): array
    {
        $password = request('password');
        $loginField = config('authentication.login_field', 'email');

        $oauth_client = [
            'id' => config('authentication.passport.client_id'),
            'secret' => config('authentication.passport.client_secret'),
        ];

        if (empty($oauth_client['id']) || empty($oauth_client['secret'])) {
            return ['error' => 'OAuth client not found'];
        }

        // Create the token request (for access token and refresh token)
        $tokenRequest = Request::create(
            '/oauth/token',
            'POST',
            [
                'grant_type' => 'password',
                'client_id' => $oauth_client['id'],
                'client_secret' => $oauth_client['secret'],
                'username' => $user->$loginField,
                'password' =>  $password, // Use the plain password from the request
                'scope' => '',
            ]
        );

        // Handle the token request
        $response = app()->handle($tokenRequest);

        if ($response->getStatusCode() != 200) {
            return ['error' => 'Invalid credentials or other error'];
        }

        // Parse and return the response with access and refresh tokens
        $tokenData = json_decode($response->getContent(), true);

        return [
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
            'token_type' => $tokenData['token_type'],
            'expires_in' => $tokenData['expires_in'],
            'user' => [
                'id' => $user->id,
                $loginField  => $user->$loginField ,
                // Add additional user fields if needed
            ],
        ];
    }

    /**
     * Revoke the Passport token for the user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function revokeToken(Authenticatable $user): void
    {
        $user->token()->revoke();
    }

    /**
     * Refresh the token.
     *
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        $oauth_client = [
            'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
        ];

        if (empty($oauth_client['id']) || empty($oauth_client['secret'])) {
            return ['error' => 'OAuth client not found'];
        }

        // Create the refresh token request
        $tokenRequest = Request::create(
            '/oauth/token',
            'POST',
            [
                'grant_type' => 'refresh_token',
                'client_id' => $oauth_client['id'],
                'client_secret' => $oauth_client['secret'],
                'refresh_token' => $refreshToken,
            ]
        );

        $response = app()->handle($tokenRequest);

        if ($response->getStatusCode() != 200) {
            return ['error' => 'Invalid refresh token or other error'];
        }

        $tokenData = json_decode($response->getContent(), true);

        return [
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
            'token_type' => $tokenData['token_type'],
            'expires_in' => $tokenData['expires_in'],
        ];
    }
}
