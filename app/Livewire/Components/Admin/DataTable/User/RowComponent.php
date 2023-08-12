<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\DataTable\User;

use App\Models\User\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\Modal\ModalComponent;
use App\View\Components\Modal\Modal as BootstrapModal;

final class RowComponent extends Component
{
    #[Locked]
    public array $hidingColumns;

    #[Reactive]
    public User $user;

    #[Reactive]
    public array $columns;

    public bool $refresh = false;

    /**
     * @var string[]
     */
    protected $listeners = ['refresh.{user.id}' => 'refresh'];

    public function edit(): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.user.edit-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            user: $this->user->id
        )->to(ModalComponent::class);
    }

    public function render(): View
    {
        // $this->gate->authorize("admin.user.view");

        return $this->viewFactory->make('livewire.admin.data-table.user.row-component');
    }
}
