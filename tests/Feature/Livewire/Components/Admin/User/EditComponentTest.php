<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\User;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use App\Livewire\Components\Admin\User\EditComponent;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class EditComponentTest extends TestCase
{
    use DatabaseTransactions;

    public static function userProvider(): array
    {
        return [
            'super-admin' => [
                function () {
                    return User::factory()->superAdmin()->create();
                },
                Response::HTTP_OK
            ],
            'admin' => [
                function () {
                    return User::factory()->admin()->create();
                },
                Response::HTTP_FORBIDDEN
            ],
            'user' => [
                function () {
                    return User::factory()->user()->create();
                },
                Response::HTTP_FORBIDDEN
            ],
            'guest' => [
                null,
                Response::HTTP_FORBIDDEN
            ]
        ];
    }

    /**
     * @dataProvider userProvider
     *
     * @test
     */
    public function test_authorize_in_render_method(?Closure $authUser, int $responseCode): void
    {
        if ($authUser) {
            $authUser = $authUser();

            $this->actingAs($authUser);

            Livewire::test(EditComponent::class, ['user' => $authUser])->assertStatus(Response::HTTP_FORBIDDEN);
        }

        $user = User::factory()->user()->create();

        Livewire::test(EditComponent::class, ['user' => $user])->assertStatus($responseCode);
    }
}
