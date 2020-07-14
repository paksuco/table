<div class="mb-4 flex justify-between items-center">
    @if($queryable)
    <div class="flex-1 pr-4">
        <div class="relative md:w-1/3">
            <input type="search" wire:model.debounce.500ms="query"
                class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                placeholder="Search...">
            <div class="absolute top-0 left-0 inline-flex items-center p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
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
        @if($pageable)
        <div class="shadow rounded-lg flex mr-3" x-data="{ open: false }">
            <div class="relative">
                <button @click.prevent="open = !open"
                    class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <path
                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                    </svg>
                    <span class="hidden md:block">{{$perPage}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="z-40 absolute top-0 right-0 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                    @foreach($perPageOptions as $perPageOption)
                    <label
                        class="@if($perPageOption == $perPage) bg-blue-600 text-white @else bg-white text-gray-700 hover:bg-gray-100 @endif cursor-pointer flex justify-start items-center text-truncate px-4 py-2"
                        wire:click="setPerPage({{$perPageOption}})"
                        @click="open = false"
                        x-text="'{{$perPageOption}}'">
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <div class="shadow rounded-lg flex" x-data="{ open: false, parent: datatables() }">
            <div class="relative">
                <button @click.prevent="open = !open"
                    class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <path
                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                    </svg>
                    <span class="hidden md:block">Display</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                    @foreach(collect($fields)->pluck("name") as $header)
                    <label
                        class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                        <div class="text-teal-600 mr-3">
                            <input type="checkbox"
                                class="form-checkbox focus:outline-none focus:shadow-outline" checked
                                @click="parent.toggleColumn('{{$header}}', $event)">
                        </div>
                        <div class="select-none text-gray-700" x-text="'{{$header}}'"></div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
