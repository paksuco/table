<?php

namespace Paksuco\Table\Contracts;

use Livewire\Castable;

class TableCaster implements Castable
{
    public function cast($value)
    {
        $class = $value["class"];
        return $value["class"]::fromArray($class, $value);
    }

    public function uncast($value)
    {
        return (new $value->class)->toArray();
    }
}
