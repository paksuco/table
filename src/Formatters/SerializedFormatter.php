<?php

namespace Paksuco\Table\Formatters;

use Paksuco\Table\Contracts\CellFormatter;

class SerializedFormatter implements CellFormatter
{
    public static function format($field, $row)
    {
        return "<pre class='break-words whitespace-pre-wrap' style='word-break: break-word'>" . var_export(json_decode($row[$field]), true) . "</pre>";
    }
}
