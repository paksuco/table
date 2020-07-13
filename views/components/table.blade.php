<div>
    {{$rows->render()}}
    @include("paksuco-table::components.filters", [$filters])
    <table>
        <thead>
            @include("paksuco-table::components.headers", [$filters])
        </thead>
        <tbody>
            @foreach($rows as $row)
            @include("paksuco-table::components.rows", $row)
            @endforeach
        </tbody>
    </table>
    {{$rows->render()}}
</div>
