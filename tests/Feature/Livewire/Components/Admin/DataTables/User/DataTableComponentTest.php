<?php

namespace Tests\Feature\Livewire\Components\Admin\DataTables\User;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Livewire\Components\Admin\DataTables\User\DataTableComponent;

class DataTableComponentTest extends TestCase
{
    use DatabaseTransactions;

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
