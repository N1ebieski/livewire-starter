<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\Home;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Components\Admin\Home\IndexComponent;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\Livewire\Components\Admin\HasUserProvider;

final class IndexComponentTest extends TestCase
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
            $this->actingAs($authUser('admin.home.view'));
        }

        Livewire::test(IndexComponent::class)->assertStatus($responseCode);
    }
}
