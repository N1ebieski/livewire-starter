<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\Role;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Symfony\Component\HttpFoundation\Response;
use App\Livewire\Components\Admin\Role\EditComponent;
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
            $this->actingAs($authUser());
        }

        $role = Role::factory()->create();

        Livewire::test(EditComponent::class, ['role' => $role])->assertStatus($responseCode);
    }

    public static function defaultProvider(): array
    {
        return [
            DefaultName::SUPER_ADMIN->value => [
                DefaultName::SUPER_ADMIN,
                Response::HTTP_FORBIDDEN
            ],
            DefaultName::ADMIN->value => [
                DefaultName::ADMIN,
                Response::HTTP_FORBIDDEN
            ],
            DefaultName::USER->value => [
                DefaultName::USER,
                Response::HTTP_OK
            ],
            DefaultName::API->value => [
                DefaultName::API,
                Response::HTTP_OK
            ],
        ];
    }

    /**
     * @dataProvider defaultProvider
     *
     * @test
     */
    public function test_authorize_defaults_in_render_method(DefaultName $name, int $responseCode): void
    {
        $user = User::factory()->superAdmin()->create();

        $this->actingAs($user);

        $role = Role::firstWhere('name', $name->value);

        Livewire::test(EditComponent::class, ['role' => $role])->assertStatus($responseCode);
    }
}
