<div class="px-3 py-2 text-sm text-black truncate dark:text-white">
    @if(($content = $column->getFooterContent()) !== null)
        {!! $content !!}
    @else
        &nbsp;
    @endif
</div>
