<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\Role;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Role\Role;
use App\Models\User\User;
use Illuminate\Support\Collection;
use App\ValueObjects\Role\DefaultName;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Livewire\Components\Admin\Role\DeleteMultiComponent;

final class DeleteMultiComponentTest extends TestCase
{
    use DatabaseTransactions;
    use HasDefaultProvider;

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
            $this->actingAs($authUser());
        }

        /** @var Collection */
        $roles = Role::factory()->count(3)->create();

        Livewire::test(DeleteMultiComponent::class, [
            'ids' => $roles->pluck('id')->toArray()
        ])->assertStatus($responseCode);
    }

    /**
     * @dataProvider defaultProvider
     *
     * @test
     */
    public function test_authorize_defaults_in_render_method(DefaultName $name): void
    {
        $user = User::factory()->superAdmin()->create();

        $this->actingAs($user);

        $role = Role::firstWhere('name', $name->value);

        /** @var Collection */
        $roles = Role::factory()->count(3)->create();

        Livewire::test(DeleteMultiComponent::class, [
            'ids' => $roles->merge([$role])->pluck('id')->toArray()
        ])->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
