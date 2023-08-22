<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Config\Repository as Config;

abstract class Request extends FormRequest
{
    public function __construct(
        protected Rule $rule,
        protected Config $config
    ) {
    }
}
