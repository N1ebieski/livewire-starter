<?php

namespace App\Livewire\Components\Modal;

use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;
use App\View\Components\Modal\Size;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\Modal\Modal;
use Illuminate\Contracts\View\Factory as ViewFactory;
use App\View\Components\Modal\Modal as BootstrapModal;

/**
 * @property-read Collection<Modal> $modals
 */
class ModalComponent extends Component
{
    #[Locked]
    public Collection $modals;

    public function mount(): void
    {
        $this->modals = new Collection();
    }

    #[On('create-modal')]
    public function create(
        array $modal,
        string $alias,
        mixed ...$params
    ): void {
        $modal['size'] = Size::tryFrom($modal['size'] ?? '');

        $this->modals->push(
            new Modal(
                modal: new BootstrapModal(...$modal),
                alias: $alias,
                params: $params
            )
        );
    }

    #[On('delete-modal')]
    public function delete(string $alias): void
    {
        $key = $this->modals->search(function (Modal $modal) use ($alias) {
            return $modal->alias === $alias;
        });

        if ($key !== false) {
            unset($this->modals[$key]);
        }
    }

    public function render(ViewFactory $view): View
    {
        return $view->make('livewire.modal.modal-component');
    }
}
