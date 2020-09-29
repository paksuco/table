@php
    $fieldCount = $has_extended ? 2 : 1;
    $rand = Str::random(6);
@endphp
<tr>
    @if($has_extended)
    <td class="border-dashed border-t border-gray-200 px-3 border-r">
        <i class="fa fa-plus-circle text-green-400 text-lg cursor-pointer"
            onclick="var item = document.querySelector('#row-{{$rand}}');
                item.classList.toggle('hidden');
                this.classList.toggle('text-green-400');
                this.classList.toggle('text-green-500');"></i>
    </td>
    @endif
    @if($settings->batchActions)
    <td class="border-dashed border-t border-gray-200 px-3">
        <label class="text-blue-700 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
            <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline">
        </label>
    </td>
    @endif
    @foreach($settings->fields as $field)
    @if($has_extended && isset($field["extended"]) && $field["extended"] == true)
        @continue
    @endif
    <td class="border-dashed border-t border-gray-200 {{$field['name']}} {{$field['class'] ?? ''}}">
        <span class="text-gray-700 px-2 py-2 flex items-center">
            @if($field["type"] == "field")
            @php $formatter = "Paksuco\\Table\\Formatters\\" . $field["format"]. "Formatter"; @endphp
            @if(class_exists($formatter))
            {!! $formatter::format($row[$field["name"]]) !!}
            @else
            {{$row[$field["name"]]}}
            @endif
            @elseif($field["type"] == "callback")
            {!! $field["format"]($row) !!}
            @endif
        </span>
    </td>
    @php $fieldCount++ @endphp
    @endforeach
</tr>
@if($has_extended)
<tr id="row-{{$rand}}" class="hidden">
    <td class="border-dashed border-t border-gray-200" colspan="{{$fieldCount}}">
        <div class="flex w-full flex-wrap">
        @foreach($settings->fields as $field)
            @if(isset($field["extended"]) && $field["extended"] == true)
            <div class="flex w-1/3">
                <label class="w-36 font-semibold px-4 py-3">{{__($field["title"] ?? $field["name"])}}</label>
                <div class="text-gray-700 px-4 py-3 flex">
                    @if($field["type"] == "field")
                    @php $formatter = "Paksuco\\Table\\Formatters\\" . $field["format"]. "Formatter"; @endphp
                    @if(class_exists($formatter))
                    {!! $formatter::format($row[$field["name"]]) !!}
                    @else
                    {{$row[$field["name"]]}}
                    @endif
                    @elseif($field["type"] == "callback")
                    {!! $field["format"]($row) !!}
                    @endif
                </div>
            </div>
            @endif
        @endforeach
        </div>
    </td>
</tr>
@endif
{{-- // Debugger
<tr>
    <td colspan="100">
        @dump($row)
    </td>
</tr>
--}}
