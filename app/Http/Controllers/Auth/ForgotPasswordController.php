<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as HttpResponse;
use App\View\Metas\Auth\ForgotEmailMetaFactory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

final class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    public function __construct(
        private ForgotEmailMetaFactory $metaFactory,
        private ResponseFactory $responseFactory,
    ) {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(): HttpResponse
    {
        $meta = $this->metaFactory->make();

        return $this->responseFactory->view('auth.passwords.email', compact('meta'));
    }
}
