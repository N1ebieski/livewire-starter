<div>
    @if(!$lazy)
    {{ $collection->links() }}
    @else
    <x-data-table.placeholder-component style="width:100px" />
    @endif
</div>