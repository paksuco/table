<?php

namespace Paksuco\Table\Components;

use Illuminate\Http\Response;
use Livewire\Component;

class Table extends Component
{
    public $model;
    public $queryable, $sortable, $pageable, $perPage;
    public $fields;
    public $filters;
    public $sorts;
    public $query;
    public $page;

    public function mount(string $model, $queryable = true, $sortable = true, $pageable = true, $perPage = 50,
        $actions = null, array $fields = [], $filters = [], $sorts = [], $query = "", $page = 1)
    {
        $this->page = $page;
        $this->model = $model;
        $this->query = $query;
        $this->queryable = $queryable;
        $this->sortable = $sortable;
        $this->pageable = $pageable;
        $this->perPage = $perPage;
        $this->actions = $actions ?? function() { return ""; };
        $this->sorts = $sorts;
        $this->fields = collect($fields);
        $this->filters = $filters;
    }

    public function render()
    {
        $rows = $this->getRows();
        return view("paksuco-table::components.table", [
            "rows" => $rows,
            "fields" => $this->fields,
        ]);
    }

    private function getRows()
    {
        if (class_exists($this->model)) {
            $query = $this->model::query();
            foreach ($this->fields as $field) {
                if ($field["type"] == "field") {
                    $query->select($field["name"]);
                }
            }
            return $query->paginate(50);
        } else {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, "Model doesn't exist: " . $this->model);
        }
    }
}
