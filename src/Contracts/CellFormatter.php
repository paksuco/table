<?php

namespace Paksuco\Table\Contracts;

interface CellFormatter
{
    public static function format($field, $row);
}