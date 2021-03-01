<?php

namespace Paksuco\Table\Formatters;

use Paksuco\Table\Contracts\CellFormatter;

class CheckboxFormatter implements CellFormatter
{
    public static function format($field, $row)
    {
        if (!!$row[$field]) {
            return "<i class='text-green-400 fa fa-check'></i>";
        }
        return "<i class='text-red-400 fa fa-times'></i>";
    }
}
