<?php

declare(strict_types=1);

namespace App\Livewire\Components\DataTable;

use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;
use App\Livewire\Components\HasDirty;
use App\Utils\DataTable\Columns\Columns;
use App\Livewire\Forms\DataTable\DataTableForm;
use App\Utils\DataTable\Columns\ColumnsFactory;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

/**
 * @property-read DataTableForm $form
 */
trait HasDataTable
{
    use WithPagination {
        WithPagination::gotoPage as baseGotoPage;
        WithPagination::previousPage as basePreviousPage;
        WithPagination::nextPage as baseNextPage;
    }
    use HasDirty;

    private Translator $translator;

    private ValidationFactory $validationFactory;

    private ColumnsFactory $columnsFactory;

    /**
     * All available columns' names to sort
     */
    #[Locked]
    public array $sorts = [];

    /**
     * All available number of entries
     */
    #[Locked]
    public array $availablePaginates = [25, 50, 100];

    /**
     * All available columns to show/hide
     */
    #[Locked]
    public array $availableColumns = [];

    /**
     * Show always specific columns
     */
    #[Locked]
    public array $showingColumns = [];

    /**
     * Hide specific columns on small devices
     */
    #[Locked]
    public array $hidingColumns = [
        'sm' => [],
        'md' => [],
        'lg' => []
    ];

    public function mountHasDataTable(
        ?array $columns = null,
        ?array $sorts = null,
        ?array $availableColumns = null,
        ?array $showingColumns = null,
        ?array $hidingColumns = null,
    ): void {
        $this->form->columns = $columns ?? $this->form->getColumns();

        $this->sorts = $sorts ?? $this->getSorts();

        $this->availableColumns = $availableColumns ?? $this->getAvailableColumns();

        $this->showingColumns = $showingColumns ?? $this->getShowingColumns();

        $this->hidingColumns = $hidingColumns ?? $this->getHidingColumns();

        $this->updateColumnsFromCookie();
    }

    public function bootHasDataTable(
        Translator $translator,
        ValidationFactory $validationFactory,
        ColumnsFactory $columnsFactory
    ): void {
        $this->translator = $translator;
        $this->validationFactory = $validationFactory;
        $this->columnsFactory = $columnsFactory;

        $this->listeners['refresh'] = '$refresh';
    }

    private function updateColumnsFromCookie(): void
    {
        if (
            !$this->columnsFactory->columnsHelper->doesUserHaveColumns(
                $this->columnsFactory->columnsHelper->getAlias($this::class)
            )
        ) {
            return;
        }

        $columns = $this->columnsFactory->makeColumns($this::class);

        $this->form->columns = array_values($columns->value);

        $this->validateWithReset();
    }

    public function bootedHasDataTable(): void
    {
        $this->dirty();

        $this->validateWithReset();
    }

    public function setOrderBy(?string $orderby): self
    {
        $this->form->orderby = $orderby;

        $this->resetPage();

        return $this;
    }

    abstract protected function getSorts(): array;

    abstract protected function getAvailableColumns(): array;

    abstract protected function getShowingColumns(): array;

    abstract protected function getHidingColumns(): array;

    protected function arePropertiesDirty(): bool
    {
        return $this->isDirty(['form.orderby', 'form.search']);
    }

    public function updatedFormColumns($value): void
    {
        $this->columnsFactory->columnsService->createCookie(
            $this->columnsFactory->columnsHelper->getAlias($this::class),
            new Columns($value)
        );
    }

    public function updatedPage(): void
    {
        $this->resetSelects();
    }

    public function renderedHasDataTable(): void
    {
        $this->dispatch('updated-page', page: $this->getPage());
    }

    /**
     *
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function updatedHasDataTable($name, $value): void
    {
        $this->dirty();

        $this->validateWithReset();

        $props = (new Collection($this->form->toArray()))
            ->keys()
            ->map(fn ($prop) => "form.{$prop}")
            ->toArray();

        if (in_array($name, $props)) {
            $this->resetPage();
            $this->resetSelects();
        }
    }

    public function validateWithReset(): void
    {
        $this->prepareForValidation(
            $this->getDataForValidation($this->form->rules())
        );

        $this->validationFactory->make($this->form->all(), $this->form->rules())
            ->after(function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $this->clear();

                    $this->columnsFactory->columnsService->removeCookie(
                        $this->columnsFactory->columnsHelper->getAlias($this::class)
                    );
                }
            })
            ->validate();
    }

    public function clear(): void
    {
        $this->form->reset();

        $this->dirty();
    }

    public function resetFormSearch(): void
    {
        $this->form->reset('search');

        $this->dirty();
    }

    private function resetSelects(): void
    {
        $this->dispatch('reset-selects');
    }

    /**
     *
     * @param mixed $page
     * @param string $pageName
     * @return void
     */
    public function gotoPage($page, $pageName = 'page'): void
    {
        $this->baseGotoPage($page, $pageName);

        $this->dispatch('gototop');
    }

    /**
     *
     * @param string $pageName
     * @return void
     */
    public function previousPage($pageName = 'page'): void
    {
        $this->basePreviousPage($pageName);

        $this->dispatch('gototop');
    }

    /**
     * @param string $pageName
     * @return void
     */
    public function nextPage($pageName = 'page'): void
    {
        $this->baseNextPage($pageName);

        $this->dispatch('gototop');
    }

    /**
     * Hide specific columns on specific devices. Component is re-render by Alpine
     * during initialization. Use with defer loading queries
     */
    public function hideColumns(string $size): void
    {
        $this->form->columns = array_diff($this->form->columns, $this->hidingColumns[$size]);
    }

    abstract protected function prepareForValidation($attributes): array;

    abstract protected function getDataForValidation($rules);

    abstract public function dispatch($event, ...$params);
}
