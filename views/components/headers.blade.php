<tr class="text-left">
    @if($has_extended)
    <th class="py-2 px-3 top-0 border-b border-r border-gray-200 bg-gray-100 relative">&nbsp;</th>
    @endif
    @if($settings->batchActions)
    <th class="py-2 px-3 top-0 border-b border-r border-gray-200 bg-gray-100">
        <label
               class="text-blue-700 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline"
                   @click="selectAllCheckbox($event);">
        </label>
    </th>
    @endif
    @foreach($settings->fields as $field)
    @if($has_extended && isset($field["extended"]) && $field["extended"] == true)
        @continue
    @endif
    @php $fieldSortable = $settings->sortable && isset($field["sortable"]) && $field["sortable"] == true; @endphp
    <th class="text-left whitespace-no-wrap border-b border-r border-gray-200 text-sm uppercase font-semibold p-2 px-4 relative
    bg-gray-100 top-0 border-b @if($fieldSortable) cursor-pointer pr-6 @endif text-gray-600  {{$field['name']}} {{$field['class'] ?? ''}}"
        x-ref="{{$field['name']}}" @if($fieldSortable) wire:click="toggleSort('{{$field['name']}}')" @endif>
        {{__($field['title'] ?? $field['name'])}}
        @if($fieldSortable)
        <span class="absolute right-2 inset-y-0 flex items-center">
            @if(!isset($settings->sorts[$field['name']]) || $settings->sorts[$field['name']] == null)
            <i class="fa fa-sort text-gray-300"></i>
            @elseif($settings->sorts[$field['name']] == "asc")
            <i class="fa fa-sort-down text-blue-600"></i>
            @elseif($settings->sorts[$field['name']] == "desc")
            <i class="fa fa-sort-up text-blue-600"></i>
            @endif
        </span>
        @endif
    </th>
    @endforeach
</tr>
