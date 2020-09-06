<?php

namespace Paksuco\Table\Formatters;

class CheckboxFormatter
{
    public static function format($value)
    {
        if (!!$value) {
            return "<i class='fa fa-check text-green-400'></i>";
        }
        return "<i class='fa fa-times text-red-400'></i>";
    }
}
