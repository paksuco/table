<tr>
    @foreach($fields as $field)
    <td>
        @if($field["type"] == "field")
        {{$row[$field["name"]]}}
        @elseif($field["type"] == "actions")
        {{$actions($row)}}
        @endif
    </td>
    @endforeach
</tr>
