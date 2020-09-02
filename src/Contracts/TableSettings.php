<?php

namespace Paksuco\Table\Contracts;

abstract class TableSettings
{
    public $model;
    public $queryable = false;
    public $sortable = false;
    public $pageable = false;
    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];
    public $fields = [];
    public $nested = false;
    public $nesting_field = null;
    public $nesting_target = "id";

    public $query = "";
    public $sorts = [];
    public $filters = [];
    public $class = "";

    public function __construct()
    {
        $this->class = get_class($this);
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public static function fromArray($class, $array)
    {
        $instance = new $class();
        foreach ($array as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }
}
