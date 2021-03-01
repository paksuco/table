<?php

namespace Paksuco\Table\Formatters;

use Paksuco\Table\Contracts\CellFormatter;
use Paksuco\Currency\Facades\Currency;

class CurrencyFormatter implements CellFormatter
{
    public static function format($field, $row)
    {
        return Currency::find($row["{$field}_currency_id"])->format($row[$field]);
    }
}
