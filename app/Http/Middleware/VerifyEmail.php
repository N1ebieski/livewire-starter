<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;

class VerifyEmail
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user() && !Auth::user()->hasVerifiedEmail()) {
            return $request->expectsJson() ?
                App::abort(
                    HttpResponse::HTTP_FORBIDDEN,
                    'Your email address is not verified'
                )
                : Response::redirectToRoute('verification.notice');
        }

        return $next($request);
    }
}
