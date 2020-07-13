<tr>
    @foreach($fields->pluck("name") as $header)
    <th>
        {{__($header)}}
    </th>
    @endforeach
</tr>
