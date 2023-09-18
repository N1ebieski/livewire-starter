@if($themeHelper->isMultiThemeEnabled())
<div class="dropdown">
    <div x-data="multiTheme({ theme: @js($currentTheme) })">   
        <a 
            class="nav-link dropdown-toggle" 
            href="#" 
            role="button" 
            data-bs-toggle="dropdown" 
            aria-haspopup="true" 
            aria-expanded="false"
        >
            <span class="me-1">
                <icon 
                    class="bi bi-custom-{{ $currentTheme }}"
                    style="font-size: 1.5rem"
                ></icon>
            </span>

            <span class="d-inline d-lg-none">
                {{ trans('default.' . $currentTheme) }}
            </span>
        </a>
        <div 
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="dropdown-multi-theme"
        >
            <h6 class="dropdown-header">
                {{ trans('default.theme_toggle') }}:
            </h6>
            @foreach($themes as $theme)
            <button 
                class="btn dropdown-item {{ $theme === $currentTheme ? 'active' : '' }}"
                title="{{ trans('default.' . $theme) }}"
                x-on:click="toggle('{{ $theme }}')"
            >
                <span class="bi bi-custom-{{ $theme }}"></span>
                <span>{{ trans('default.' . $theme) }}</span>
            </button>
            @endforeach                       
        </div>
    </div>
</div>
@endif