<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\SignInRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(SignInRequest $request)
    {
        // TODO: Translate to russian

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);


        return $this->sendError('Invalid credentials');

    }

    protected function sendLoginResponse(Request $request)
    {

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $this->clearLoginAttempts($request);

        return $request->wantsJson()
            ? $this->sendResponse(['user' => auth()->user(), 'access_token' => $accessToken], 'Sign in success!')
            : redirect()->intended($this->redirectPath());
    }
}
