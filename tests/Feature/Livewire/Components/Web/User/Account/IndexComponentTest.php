<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Web\User\Account;

use Closure;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Livewire\Components\Web\User\Account\IndexComponent;
use Tests\Feature\Livewire\Components\Web\User\HasUserProvider;

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
            $this->actingAs($authUser());
        }

        Livewire::test(IndexComponent::class)->assertStatus($responseCode);
    }
}
