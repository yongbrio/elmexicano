<div class="px-3 py-2 text-sm text-black truncate dark:text-white">
    @if($column->isRaw())
        {!! $value !!}
    @else
        {{ $value }}
    @endif
</div>
