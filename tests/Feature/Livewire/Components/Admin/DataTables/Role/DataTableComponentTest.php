<?php

namespace Tests\Feature\Livewire\Components\Admin\DataTables\Role;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\Livewire\Components\Admin\HasUserProvider;
use App\Livewire\Components\Admin\DataTables\Role\DataTableComponent;

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
            $this->actingAs($authUser('admin.role.view'));
        }

        Livewire::test(DataTableComponent::class)->assertStatus($responseCode);
    }
}
