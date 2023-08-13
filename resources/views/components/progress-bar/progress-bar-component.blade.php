<div 
    {{ $attributes->class(['progress-stacked'])->filter(fn ($value) => is_string($value)) }}    
    style="height: 20px"
>
    @foreach($segments as $segment)
    <div 
        class="progress" 
        role="progressbar" 
        aria-label="{{ $segment->label }}" 
        aria-valuenow="{{ $segment->value }}"
        aria-valuemin="{{ $min }}" 
        aria-valuemax="{{ $max }}"
        style="width: {{ $segment->value }}%; height: 20px"
    >
        <div 
            class="progress-bar progress-bar-striped bg-{{ $segment->action->value }} {{ $active ? 'progress-bar-animated' : '' }}" 
        >
            {{ $segment->value }}%
        </div>
    </div>
    @endforeach
</div>