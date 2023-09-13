<?php

namespace Tests\Feature\Livewire\Components\Admin\DataTables\User;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\Livewire\Components\Admin\HasUserProvider;
use App\Livewire\Components\Admin\DataTables\User\DataTableComponent;

final class DataTableComponentTest extends TestCase
{
    use DatabaseTransactions;
    use HasUserProvider;

    /**
     * @dataProvider userProvider
     *
     * @test
     */
    public function test_authorize_in_render_method(?Closure $authUser, int $responseCode): void
    {
        if ($authUser) {
            $this->actingAs($authUser('admin.user.view'));
        }

        Livewire::test(DataTableComponent::class)->assertStatus($responseCode);
    }

    public static function toggleStatusEmailUserProvider(): array
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
        ];
    }

    /**
     * @dataProvider toggleStatusEmailUserProvider
     *
     * @test
     */
    public function test_authorize_in_toggleStatusEmail_method(Closure $authUser, int $responseCode): void
    {
        $authUser = $authUser();

        $this->actingAs($authUser);

        $user = User::factory()->user()->create();

        Livewire::test(DataTableComponent::class)
            ->call('toggleStatusEmail', [$user->id])
            ->assertStatus($responseCode);

        Livewire::test(DataTableComponent::class)
            ->call('toggleStatusEmail', [$authUser->id])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function test_whether_component_supports_locked_attributes_in_mount(): void
    {
        $user = User::factory()->superAdmin()->create();

        /** @var Role */
        $role = Role::where('name', DefaultName::USER->value)->first();

        /** @var array<Attribute> */
        $lockedAttributes = [
            new Attribute(
                name: 'form.role',
                from: null,
                to: $role->id
            )
        ];

        $this->actingAs($user);

        /** Without a locked attribute */
        $response = Livewire::test(DataTableComponent::class);

        foreach ($lockedAttributes as $attribute) {
            $response->assertSet($attribute->name, $attribute->from)
                ->set($attribute->name, $attribute->to)
                ->assertSet($attribute->name, $attribute->to);
        }

        /** With a locked attribute */
        $response = Livewire::test(DataTableComponent::class, [
            'lockedAttributes' => array_map(
                fn (Attribute $attribute) => $attribute->name,
                $lockedAttributes
            )
        ]);

        foreach ($lockedAttributes as $attribute) {
            $this->expectExceptionMessageMatches('/Cannot update locked property:.*?' . $attribute->name . '/');

            $response->assertSet($attribute->name, $attribute->from)->set($attribute->name, $attribute->to);
        }
    }
}
