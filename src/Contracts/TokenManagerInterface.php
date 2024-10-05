<?php

namespace Intrazero\AuthBoilerplate\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface TokenManagerInterface
{
    /**
     * Generate a token for the authenticated user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return string
     */
    public function createToken(Authenticatable $user): array;

    /**
     * Revoke the token for the authenticated user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function revokeToken(Authenticatable $user): void;


        /**
     * Refresh the token using a refresh token.
     *
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array;
}
