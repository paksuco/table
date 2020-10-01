@php
    $fieldCount = $has_extended ? 2 : 1;
    $rand = Str::random(6);
@endphp
<tr>
    @if($has_extended)
    <td class="border-dashed border-t border-gray-200 text-center p-2 border-r">
        <i class="fa fa-plus-circle text-green-400 text-2xl cursor-pointer"
            onclick="var item = document.querySelector('#row-{{$rand}}');
                item.classList.toggle('hidden');
                this.classList.toggle('text-green-400');
                this.classList.toggle('text-green-500');"></i>
    </td>
    @endif
    @if($settings->batchActions)
    <td class="border-dashed border-t border-gray-200 p-2">
        <label class="text-blue-700 inline-flex justify-between items-center hover:bg-gray-200 rounded-lg cursor-pointer">
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
        @php $formatter = "Paksuco\\Table\\Formatters\\" . $field["format"]. "Formatter"; @endphp
        @if(class_exists($formatter))
    -->{!! $formatter::format($row[$field["name"]]) !!}<!--
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
    <td class="p-2 bg-gray-700 text-white" colspan="{{$fieldCount}}">
        <div class="flex w-full flex-wrap whitespace-pre-line">
        @foreach($settings->fields as $field)
            @if(isset($field["extended"]) && $field["extended"] == true)
            <div class="flex w-full">
                <label class="w-36 font-semibold px-2">{{__($field["title"] ?? $field["name"])}}</label>
                <div class="text-gray-100 px-2 flex"><!--
                    @if($field["type"] == "field")
                    @php $formatter = "Paksuco\\Table\\Formatters\\" . $field["format"]. "Formatter"; @endphp
                    @if(class_exists($formatter))
                -->{!! $formatter::format($row[$field["name"]]) !!}<!--
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
