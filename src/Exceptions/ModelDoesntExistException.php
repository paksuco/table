<?php

namespace Paksuco\Table\Exceptions;

use Exception;

class ModelDoesntExistException extends Exception
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function __toString()
    {
        return "Model doesn't exist: " . $this->model;
    }
}
