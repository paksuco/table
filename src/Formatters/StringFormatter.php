<?php

namespace Paksuco\Table\Formatters;

use Illuminate\Support\Facades\App;
use Paksuco\Table\Contracts\CellFormatter;

class StringFormatter implements CellFormatter
{
    public static function format($field, $row)
    {
        $value = $row[$field];

        if (substr($value, 0, 1) == "{") {
            $json = json_decode(stripslashes($value), true);
            if (is_array($json)) {
                if (array_key_exists(App::getLocale(), $json)) {
                    return $json[App::getLocale()] . "";
                } else if (array_key_exists(config("app.fallback_locale"), $json)) {
                    return $json[config("app.fallback_locale")] . "";
                }
            }
        }

        return $value . "";
    }
}
