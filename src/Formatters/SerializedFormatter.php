<?php

namespace Paksuco\Table\Formatters;

class SerializedFormatter
{
    public static function format($value)
    {
        return "<pre class='break-words whitespace-pre-wrap' style='word-break: break-word'>" . var_export(json_decode($value), true) . "</pre>";
    }
}
