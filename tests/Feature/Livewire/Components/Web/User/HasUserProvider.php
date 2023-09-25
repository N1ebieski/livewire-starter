<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Web\User;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;

trait HasUserProvider
{
    public static function userProvider(): array
    {
        return [
            'user' => [
                function () {
                    return User::factory()->user()->create();
                },
                Response::HTTP_OK
            ],
            'guest' => [
                null,
                Response::HTTP_FORBIDDEN
            ]
        ];
    }
}
