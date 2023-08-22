<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\View\Metas\Auth\ResetPasswordMetaFactory;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(
        private ResetPasswordMetaFactory $metaFactory,
        private ResponseFactory $responseFactory,
    ) {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request): HttpResponse
    {
        $meta = $this->metaFactory->make();

        $token = $request->route()->parameter('token');

        return $this->responseFactory->view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
            'meta' => $meta
        ]);
    }
}
