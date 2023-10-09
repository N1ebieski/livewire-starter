<?php

declare(strict_types=1);

namespace App\Livewire\Components\DataTable;

use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;
use App\Livewire\Components\HasDirty;
use App\View\DataTable\Columns\Columns;
use App\View\DataTable\Columns\ColumnsFactory;
use Illuminate\Contracts\Validation\Validator;
use App\Livewire\Forms\DataTable\DataTableForm;
use Illuminate\Contracts\Translation\Translator;
use Livewire\Features\SupportAttributes\AttributeCollection;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

/**
 * @property-read DataTableForm $form
 * @property AttributeCollection $attributes
 * @property DataTableForm $form
 */
trait HasDataTable
{
    use WithPagination;
    use HasDirty;

    private Translator $translator;

    private ValidationFactory $validationFactory;

    private ColumnsFactory $columnsFactory;

    private Str $str;

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

    /**
     * Locked specific form attributes
     */
    #[Locked]
    public ?array $lockedAttributes = null;

    /**
     * Pass to url specific form attributes
     */
    #[Locked]
    public ?array $urlAttributes = null;

    /**
     * All available filters
     */
    #[Locked]
    public ?array $filters = null;

    /**
     * Whether show a "page" query param and push state to history
     */
    #[Locked]
    public bool $showPage = true;

    public function mountHasDataTable(
        ?array $columns = null,
        ?array $sorts = null,
        ?array $filters = null,
        ?array $availableColumns = null,
        ?array $showingColumns = null,
        ?array $hidingColumns = null,
        ?array $lockedAttributes = null,
        ?array $urlAttributes = null,
        bool $showPage = true
    ): void {
        $this->form->columns = $columns ?? $this->form->getColumns();

        $this->sorts = $sorts ?? $this->getSorts();

        $this->availableColumns = $availableColumns ?? $this->getAvailableColumns();

        $this->showingColumns = $showingColumns ?? $this->getShowingColumns();

        $this->hidingColumns = $hidingColumns ?? $this->getHidingColumns();

        $this->filters = $filters ?? $this->getFilters();

        $this->lockedAttributes = $lockedAttributes;

        $this->urlAttributes = $urlAttributes;

        $this->showPage = $showPage;

        $this->setPaginators();

        $this->updateColumnsFromCookie();
    }

    public function bootHasDataTable(
        Translator $translator,
        ValidationFactory $validationFactory,
        ColumnsFactory $columnsFactory,
        Str $str
    ): void {
        $this->translator = $translator;
        $this->validationFactory = $validationFactory;
        $this->columnsFactory = $columnsFactory;
        $this->str = $str;

        $this->listeners['refresh'] = '$refresh';

        $this->updateLockedAttributes();

        $this->updateUrlAttributes();
    }

    /**
     * Fix. Livewire doesn't support disabling a page param in the query string.
     * This hack terminate a function SupportPagination::ensurePaginatorIsInitialized
     */
    private function setPaginators(): void
    {
        if (!$this->showPage) {
            $this->paginators['page'] = 1;
        }
    }

    private function updateUrlAttributes(): void
    {
        if (is_null($this->urlAttributes)) {
            return;
        }

        $this->attributes->each(function ($attribute, $key) {
            if (!$attribute instanceof Url) {
                return;
            }

            if (!$this->str->startsWith($attribute->getName(), 'form.')) {
                return;
            }

            $this->attributes->forget($key);
        });

        foreach ($this->urlAttributes as $attribute) {
            $this->setPropertyAttribute(
                $attribute,
                new Url(as: $this->str->match('/\.([^.]*?)$/', $attribute))
            );
        }
    }

    private function updateLockedAttributes(): void
    {
        if (is_null($this->lockedAttributes)) {
            return;
        }

        $this->attributes->each(function ($attribute, $key) {
            if (!$attribute instanceof Url) {
                return;
            }

            if (!$this->str->startsWith($attribute->getName(), 'form.')) {
                return;
            }

            $this->attributes->forget($key);
        });

        foreach ($this->lockedAttributes as $attribute) {
            $this->setPropertyAttribute($attribute, new Locked());
        }
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

        $this->reset('hidingColumns');

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

    protected function arePropertiesDirty(): bool
    {
        return $this->isDirty(['form.orderby', 'form.search']);
    }

    public function updatedFormColumns(array $value): void
    {
        $this->reset('hidingColumns');

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
        if ($this->showPage) {
            $this->dispatch('updated-page', page: $this->getPage());
        }
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
        $attributes = ['columns'];

        if ($this->lockedAttributes) {
            $attributes = array_merge($attributes, array_map(
                fn (string $attribute) => $this->str->match('/^form\.(.*)/', $attribute),
                $this->lockedAttributes
            ));
        }

        $this->form->resetExcept(...$attributes);

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
     * Hide specific columns on specific devices. Component is re-render by Alpine
     * during initialization.
     */
    public function hideColumns(string $size): void
    {
        $this->form->columns = array_diff($this->form->columns, $this->hidingColumns[$size]);
    }

    abstract protected function getSorts(): array;

    abstract protected function getFilters(): array;

    abstract protected function getAvailableColumns(): array;

    abstract protected function getShowingColumns(): array;

    abstract protected function getHidingColumns(): array;

    abstract protected function prepareForValidation($attributes): array;

    abstract protected function getDataForValidation($rules);

    abstract public function dispatch($event, ...$params);
}
