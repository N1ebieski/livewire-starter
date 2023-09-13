<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\User;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Livewire\Components\Admin\User\DeleteMultiComponent;

final class DeleteMultiComponentTest extends TestCase
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
        /** @var Collection */
        $users = User::factory()->count(3)->create();

        if ($authUser) {
            $authUser = $authUser();

            $this->actingAs($authUser);

            Livewire::test(DeleteMultiComponent::class, [
                'ids' => $users->merge([$authUser])->pluck('id')->toArray()
            ])->assertStatus(Response::HTTP_FORBIDDEN);
        }

        Livewire::test(DeleteMultiComponent::class, [
            'ids' => $users->pluck('id')->toArray()
        ])->assertStatus($responseCode);
    }
}
