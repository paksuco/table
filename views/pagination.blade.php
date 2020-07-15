@if ($paginator->hasPages())
<div class="flex mt-4">
    <div class="flex items-center justify-center mr-5 text-gray-700 hidden md:block">
        <div>Showing <span class="font-semibold">{{$paginator->firstItem()}}</span> to <span class="font-semibold">{{$paginator->lastItem()}}</span> of <span class="font-semibold">{{$paginator->total()}}</span> items</div>
    </div>
    <ul class="flex flex-1 justify-end" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="px-5 py-2 shadow rounded-l-lg bg-white text-gray-300" aria-text-gray-300="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">
                    <span class="hidden md:block">&lsaquo;</span>
                    <span class="block md:hidden">@lang('pagination.previous')</span>
                </span>
            </li>
        @else
            <li class="px-5 py-2 shadow rounded-l-lg bg-white">
                <button type="button" class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="hidden md:block">&lsaquo;</span>
                    <span class="block md:hidden">@lang('pagination.previous')</span>
                </button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="px-3 py-2 mx-0 text-gray-300 hidden md:block" aria-text-gray-300="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="px-5 py-2 bg-blue-600 shadow text-white hidden md:block" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="px-5 py-2 shadow bg-white hidden md:block"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="px-5 py-2 shadow rounded-r-lg bg-white ">
                <button type="button" class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">
                    <span class="block md:hidden">@lang('pagination.next')</span>
                    <span class="hidden md:block">&rsaquo;</span>
                </button>
            </li>
        @else
            <li class="px-5 py-2 shadow rounded-r-lg bg-white text-gray-300" aria-text-gray-300="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">
                    <span class="block md:hidden">@lang('pagination.next')</span>
                    <span class="hidden md:block">&rsaquo;</span>
                </span>
            </li>
        @endif
    </ul>
</div>
@endif
