<tr class="text-left">
    <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
        <label
            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline"
                @click="selectAllCheckbox($event);">
        </label>
    </th>
    @foreach(collect($fields)->pluck("name") as $header)
    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs" x-ref="{{$header}}">
        {{__($header)}}
    </th>
    @endforeach
</tr>
