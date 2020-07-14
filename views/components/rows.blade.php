<tr>
    <td class="border-dashed border-t border-gray-200 px-3">
        <label class="text-blue-700 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
            <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline">
        </label>
    </td>
    @foreach($fields as $field)
    <td class="border-dashed border-t border-gray-200 {{$field['name']}} {{$field['class'] ?? ''}}">
        <span class="text-gray-700 px-4 py-3 flex items-center">
            @if($field["type"] == "field")
            {{$row[$field["name"]]}}
            @elseif($field["type"] == "callback")
            {!! $field["format"]($row) !!}
            @endif
        </span>
    </td>
    @endforeach
</tr>
