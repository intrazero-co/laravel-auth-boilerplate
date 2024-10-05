<?php

namespace Intrazero\AuthBoilerplate\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intrazero\AuthBoilerplate\Services\AuthenticationManager;
use Intrazero\AuthBoilerplate\Traits\LoginTrait;
use Intrazero\AuthBoilerplate\Traits\RegisterTrait;
use Intrazero\AuthBoilerplate\Traits\LogoutTrait;

class AuthController extends Controller
{
    use LoginTrait, RegisterTrait, LogoutTrait;

    protected $authManager;

    public function __construct(AuthenticationManager $authManager)
    {
        $this->authManager = $authManager;
    }

    // /**
    //  * Handle user login.
    //  * Delegates to the LoginTrait's login method.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function login(Request $request)
    // {

    //     return $this->login($request, $this->authManager);
    // }

    // /**
    //  * Handle user registration.
    //  * Delegates to the RegisterTrait's register method.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function register(Request $request)
    // {


    //     return $this->register($request, $this->authManager);
    // }

    // /**
    //  * Handle user logout.
    //  * Delegates to the LogoutTrait's logout method.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function logout(Request $request)
    // {
    //     return $this->logout($request, $this->authManager);
    // }
}
