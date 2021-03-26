<?php

namespace Paksuco\Table\Contracts;

use Illuminate\Support\Facades\Request;

abstract class TableSettings
{
    public $model;
    public $relations = [];
    public $counts = [];

    public $queryable = false;
    public $sortable = false;
    public $pageable = false;

    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];

    public $fields = [];
    public $trashed = false;

    public $nested = false;
    public $nestingField = null;
    public $nestingTarget = "id";

    public $batchActions = false;

    public $query   = "";
    public $sorts   = [];
    public $filters = [];
    public $class   = "";

    public $appends = [];

    public function __construct()
    {
        $this->class   = get_called_class();
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
