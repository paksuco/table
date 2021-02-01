<div class="flex items-center justify-between mb-4">
    @if($settings->queryable)
    <div class="flex-1 pr-4">
        <div class="relative md:w-1/3">
            <input type="search" wire:model.debounce.500ms="settings.query"
                class="w-full py-2 pl-8 pr-4 font-medium text-gray-600 border rounded shadow-sm focus:outline-none focus:shadow-outline"
                placeholder="@lang('Search...')">
            <div class="absolute inset-y-0 inline-flex items-center justify-center left-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                    <circle cx="10" cy="10" r="7" />
                    <line x1="21" y1="21" x2="15" y2="15" />
                </svg>
            </div>
        </div>
    </div>
    @else
    <div class="flex-1 pr-4"></div>
    @endif
    <div class="flex">
        @if($settings->pageable)
        <div class="flex mr-3 border rounded shadow-sm" x-data="{ open: false }">
            <div class="relative">
                <button @click.prevent="open = !open"
                    class="inline-flex items-center px-2 py-2 font-semibold text-gray-500 bg-white rounded hover:text-blue-500 focus:outline-none focus:shadow-outline md:px-4">
                    <span>{{$settings->perPage}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute top-0 right-0 z-40 block w-16 py-1 mt-12 -mr-1 overflow-hidden bg-white border rounded shadow-sm">
                    @foreach($settings->perPageOptions as $perPageOption)
                    <label
                        class="@if($perPageOption == $settings->perPage) bg-blue-600 text-white @else
                        bg-white text-gray-700 hover:bg-gray-100 @endif cursor-pointer flex justify-end
                        items-center text-truncate px-4 py-2"
                        wire:click="setPerPage({{$perPageOption}})"
                        @click="open = false"
                        x-text="'{{$perPageOption}}'">
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <div class="flex border rounded shadow-sm" x-data="{ open: false, parent: datatables() }">
            <div class="relative">
                <button @click.prevent="open = !open"
                    class="inline-flex items-center px-2 py-2 font-semibold text-gray-500 bg-white rounded hover:text-blue-500 focus:outline-none focus:shadow-outline md:px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <path
                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                    </svg>
                    <span class="hidden md:block">@lang('Display')</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute top-0 right-0 z-40 block w-64 py-1 mt-12 -mr-1 overflow-hidden bg-white border rounded shadow-sm">
                    @foreach(collect($settings->fields)->pluck("title", "name") as $key => $header)
                    <label
                        class="flex items-center justify-start px-4 py-2 text-truncate hover:bg-gray-100">
                        <div class="mr-3 text-teal-600">
                            <input type="checkbox"
                                class="form-checkbox focus:outline-none focus:shadow-outline" checked
                                @click="parent.toggleColumn('{{$key}}', $event)">
                        </div>
                        <div class="text-gray-700 select-none" x-text="'{{__($header ?? $key)}}'"></div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
