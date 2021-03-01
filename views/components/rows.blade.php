@php
    $fieldCount = $has_extended ? 2 : 1;
    $rand = Str::random(6);
@endphp
<tr class="align-top border-t border-gray-300 hover:bg-indigo-50 {{$loop->index % 2 === 0 ? 'bg-cool-gray-50' : ''}}">
    @if($has_extended)
    <td class="p-2 text-center border-t border-r border-gray-200 border-dashed">
        <i class="text-2xl text-green-400 cursor-pointer fa fa-plus-circle"
            onclick="var item = document.querySelector('#row-{{$rand}}');
                item.classList.toggle('hidden');
                this.classList.toggle('text-green-400');
                this.classList.toggle('text-green-500');"></i>
    </td>
    @endif
    @if($settings->batchActions)
    <td class="p-2 border-t border-gray-200 border-dashed">
        <label class="inline-flex items-center justify-between text-blue-700 rounded-lg cursor-pointer hover:bg-gray-200">
            <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline">
        </label>
    </td>
    @endif
    @foreach($settings->fields as $field)
    @if($has_extended && isset($field["extended"]) && $field["extended"] == true)
        @continue
    @endif
    <td class="border-dashed border-t border-gray-200 p-2 {{$field['name']}} {{$field['class'] ?? ''}}"><!--
        @if($field["type"] == "field")
        @php $formatter = "\\Paksuco\\Table\\Formatters\\" . ucfirst($field["format"]). "Formatter"; @endphp
        @if(class_exists($formatter))
    -->{!! $formatter::format($field["name"], $row) !!}<!--
        @else
    -->{{$row[$field["name"]]}}<!--
        @endif
        @elseif($field["type"] == "callback")
    -->{!! $field["format"]($row) !!}<!--
        @endif
--></td>
    @php $fieldCount++ @endphp
    @endforeach
</tr>
@if($has_extended)
<tr id="row-{{$rand}}" class="hidden">
    <td class="p-2 text-white bg-gray-700" colspan="{{$fieldCount}}">
        <div class="flex flex-wrap w-full whitespace-pre-line">
        @foreach($settings->fields as $field)
            @if(isset($field["extended"]) && $field["extended"] == true)
            <div class="flex w-full">
                <label class="px-2 font-semibold w-36">{{__($field["title"] ?? $field["name"])}}</label>
                <div class="flex px-2 text-gray-100"><!--
                    @if($field["type"] == "field")
                    @php $formatter = "Paksuco\\Table\\Formatters\\" . $field["format"]. "Formatter"; @endphp
                    @if(class_exists($formatter))
                -->{!! $formatter::format($field["name"] ,$row) !!}<!--
                    @else
                -->{{$row[$field["name"]]}}<!--
                    @endif
                    @elseif($field["type"] == "callback")
                -->{!! $field["format"]($row) !!}<!--
                    @endif
                --></div>
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
