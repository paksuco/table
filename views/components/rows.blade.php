<tr>
    @foreach($fields as $field)
    <td>
        @if($field["type"] == "field")
        {{$row[$field["name"]]}}
        @elseif($field["type"] == "callback")
        {!! $field["format"]($row) !!}
        @endif
    </td>
    @endforeach
</tr>
