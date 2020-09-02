<?php

namespace Paksuco\Table\Contracts;

use Livewire\Castable;

class TableCaster implements Castable
{
    public function cast($value)
    {
        $class = $value["class"];
        return $class::fromArray($class, $value);
    }

    public function uncast($value)
    {
        return $value->toArray();
    }
}
