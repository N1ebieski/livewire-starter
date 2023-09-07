<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\View\Metas\Auth\LoginMetaFactory;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Requests\Auth\Login\LoginRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

final class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(
        private LoginRequest $loginRequest,
        private LoginMetaFactory $metaFactory,
        private ResponseFactory $responseFactory,
    ) {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): HttpResponse
    {
        $meta = $this->metaFactory->make();

        return $this->responseFactory->view('auth.login', compact('meta'));
    }

    public function redirectTo(): string
    {
        return $this->loginRequest->input('redirect') ?? $this->redirectTo;
    }
}
