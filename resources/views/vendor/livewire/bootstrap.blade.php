<div>
    @if ($paginator->hasPages())
        <nav>
            <ul class="pagination pagination-sm">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li 
                        class="page-item disabled" 
                        aria-disabled="true" 
                        aria-label="@lang('pagination.previous')"
                    >
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <button 
                            type="button" 
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" 
                            class="page-link" 
                            wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                            wire:loading.attr="disabled" 
                            rel="prev" 
                            aria-label="@lang('pagination.previous')"
                        >
                            <span 
                                wire:loading.remove 
                                wire:target="previousPage('{{ $paginator->getPageName() }}')"
                            >
                                &lsaquo;
                            </span>
                            <span 
                                class="d-none"
                                wire:loading 
                                wire:target="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.class.remove="d-none" 
                            >
                                <span 
                                    class="spinner-border spinner-border-sm" 
                                    role="status" 
                                    aria-hidden="true"
                                ></span>
                                <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                            </span>                                    
                        </button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li 
                            class="page-item disabled" 
                            aria-disabled="true"
                        >
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li 
                                    class="page-item active" 
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" 
                                    aria-current="page"
                                >
                                    <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                                <li 
                                    class="page-item" 
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                >
                                    <button 
                                        type="button" 
                                        class="page-link" 
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    >
                                        <span 
                                            wire:loading.remove 
                                            wire:target="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        >
                                            {{ $page }}
                                        </span>
                                        <span 
                                            class="d-none"
                                            wire:loading 
                                            wire:target="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            wire:loading.class.remove="d-none" 
                                        >
                                            <span 
                                                class="spinner-border spinner-border-sm" 
                                                role="status" 
                                                aria-hidden="true"
                                            ></span>
                                            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                                        </span>   
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button 
                            type="button" 
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" 
                            class="page-link" 
                            wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                            wire:loading.attr="disabled" 
                            rel="next" 
                            aria-label="@lang('pagination.next')"
                        >
                            <span 
                                wire:loading.remove 
                                wire:target="nextPage('{{ $paginator->getPageName() }}')"
                            >
                                &rsaquo;
                            </span>
                            <span 
                                class="d-none"
                                wire:loading 
                                wire:target="nextPage('{{ $paginator->getPageName() }}')"
                                wire:loading.class.remove="d-none" 
                            >
                                <span 
                                    class="spinner-border spinner-border-sm" 
                                    role="status" 
                                    aria-hidden="true"
                                ></span>
                                <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                            </span>     
                        </button>
                    </li>
                @else
                    <li 
                        class="page-item disabled" 
                        aria-disabled="true" 
                        aria-label="@lang('pagination.next')"
                    >
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
