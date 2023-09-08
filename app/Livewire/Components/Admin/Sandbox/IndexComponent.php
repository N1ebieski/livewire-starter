<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Sandbox;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\FullPageInterface;
use App\View\Metas\Admin\Home\IndexMetaFactory;

final class IndexComponent extends Component implements FullPageInterface
{
    use HasComponent;

    public ?string $autocomplete = 'example';

    public ?string $tinymce = 'example text';

    public ?string $datetime = null;

    public function submit(): void
    {
        dump($this->all());
    }

    public function render(IndexMetaFactory $metaFactory): View
    {
        $this->gate->authorize('admin.home.view');

        $meta = $metaFactory->make();

        return $this->viewFactory->make('livewire.admin.sandbox.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
