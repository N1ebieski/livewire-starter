<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\View\Metas\Auth\VerificationMetaFactory;
use Illuminate\Contracts\Routing\ResponseFactory;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(
        private VerificationMetaFactory $metaFactory,
        private ResponseFactory $responseFactory,
    ) {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request): HttpResponse|RedirectResponse
    {
        /** @var User */
        $user = $request->user();

        $meta = $this->metaFactory->make();

        return $user->hasVerifiedEmail()
            ? $this->responseFactory->redirectTo($this->redirectPath())
            : $this->responseFactory->view('auth.verify', compact('meta'));
    }
}
