<?php

namespace Intrazero\AuthBoilerplate\Services;

use Intrazero\AuthBoilerplate\Contracts\TokenManagerInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthenticationManager
{
    /**
     * The token manager instance.
     *
     * @var \Intrazero\AuthBoilerplate\Contracts\TokenManagerInterface
     */
    protected $tokenManager;

    /**
     * AuthenticationManager constructor.
     *
     * @param \Intrazero\AuthBoilerplate\Contracts\TokenManagerInterface $tokenManager
     */
    public function __construct(TokenManagerInterface $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Generate a token for the authenticated user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return string
     */
    public function createToken(Authenticatable $user): array
    {
        return $this->tokenManager->createToken($user);
    }

    /**
     * Revoke the token for the authenticated user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function revokeToken(Authenticatable $user): void
    {
        $this->tokenManager->revokeToken($user);
    }
}
