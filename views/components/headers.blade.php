<tr class="text-left">
    <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
        <label
               class="text-blue-700 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline"
                   @click="selectAllCheckbox($event);">
        </label>
    </th>
    @foreach($fields as $field)
    @php $fieldSortable = $sortable && isset($field["sortable"]) && $field["sortable"] == true; @endphp
    <th class="bg-gray-100 sticky top-0 border-b @if($fieldSortable) cursor-pointer pr-6 @endif border-gray-200 px-4 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs {{$field['name']}} {{$field['class'] ?? ''}}"
        x-ref="{{$field['name']}}" @if($fieldSortable) wire:click="toggleSort('{{$field['name']}}')" @endif>
        {{__($field['name'])}}
        @if($fieldSortable)
        <span class="absolute right-2 inset-y-0 flex items-center">
            @if(!isset($sorts[$field['name']]) || $sorts[$field['name']] == null)
            <i class="fa fa-sort text-gray-300"></i>
            @elseif($sorts[$field['name']] == "asc")
            <i class="fa fa-sort-down text-blue-600"></i>
            @elseif($sorts[$field['name']] == "desc")
            <i class="fa fa-sort-up text-blue-600"></i>
            @endif
        </span>
        @endif
    </th>
    @endforeach
</tr>
