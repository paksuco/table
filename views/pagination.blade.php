@if ($paginator->hasPages())
<div class="flex items-start mt-4">
    <div class="items-center justify-center hidden mr-5 text-gray-700 md:block">
        <div>@lang("Showing :start to :end of :count items", [
            "start" => '<span class="font-semibold">' . $paginator->firstItem() . '</span>',
            "end" => '<span class="font-semibold">'. $paginator->lastItem() . '</span>',
            "count" => '<span class="font-semibold">' . $paginator->total() . '</span>'
        ])</div>
    </div>
    <ul class="flex justify-end flex-1" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="text-gray-300 bg-white rounded-l-lg shadow" aria-text-gray-300="true" aria-label="@lang('pagination.previous')">
                <span class="block px-4 py-2 page-link" aria-hidden="true">
                    <span class="hidden md:block">&lsaquo;</span>
                    <span class="block md:hidden">@lang('pagination.previous')</span>
                </span>
            </li>
        @else
            <li class="bg-white rounded-l-lg shadow">
                <button type="button" class="px-4 py-2 page-link " wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="hidden md:block">&lsaquo;</span>
                    <span class="block md:hidden">@lang('pagination.previous')</span>
                </button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="hidden mx-0 text-gray-300 md:block" aria-text-gray-300="true"><span class="block px-3 py-2 page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="hidden text-white bg-blue-600 shadow  md:block" aria-current="page"><span class="block px-4 py-2 page-link">{{ $page }}</span></li>
                    @else
                        <li class="hidden bg-white shadow md:block"><button type="button" class="px-4 py-2 page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="bg-white rounded-r-lg shadow ">
                <button type="button" class="px-4 py-2 page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">
                    <span class="block md:hidden">@lang('pagination.next')</span>
                    <span class="hidden md:block">&rsaquo;</span>
                </button>
            </li>
        @else
            <li class="text-gray-300 bg-white rounded-r-lg shadow" aria-text-gray-300="true" aria-label="@lang('pagination.next')">
                <span class="block px-5 py-2 page-link" aria-hidden="true">
                    <span class="block md:hidden">@lang('pagination.next')</span>
                    <span class="hidden md:block">&rsaquo;</span>
                </span>
            </li>
        @endif
    </ul>
</div>
@endif
