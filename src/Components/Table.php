<?php

namespace Paksuco\Table\Components;

use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $model;
    public $queryable;
    public $sortable;
    public $pageable;
    public $perPage;
    public $perPageOptions;
    public $fields;
    public $filters;
    public $sorts;
    public $query;

    public function mount(
        $model,
        $queryable = true,
        $sortable = true,
        $pageable = true,
        $perPage = 50,
        $perPageOptions = null,
        $fields = null,
        $filters = null,
        $sorts = null,
        $query = ""
    ) {
        $this->model = $model ?? "";
        $this->query = $query ?? "";
        $this->queryable = $queryable;
        $this->sortable = $sortable;
        $this->pageable = $pageable;
        $this->perPageOptions = $perPageOptions ?? [10, 25, 50, 100];
        $this->perPage = $perPage ?? $this->perPageOptions[0];
        $this->sorts = $sorts ?? [];
        $this->fields = $fields ?? [];
        $this->filters = $filters ?? [];
    }

    public static function formatActions($row)
    {
        return "";
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function render()
    {
        $rows = $this->getRows();
        return view("paksuco-table::components.table", [
            "rows" => $rows,
            "fields" => $this->fields,
        ]);
    }

    public function toggleSort($name)
    {
        if($this->sortable){
            if (array_key_exists($name, $this->sorts) == true) {
                switch ($this->sorts[$name]) {
                    case null:$this->sorts[$name] = "asc";
                        break;
                    case "asc":$this->sorts[$name] = "desc";
                        break;
                    case "desc":$this->sorts[$name] = null;
                        break;
                    default:$this->sorts[$name] = "asc";
                        break;
                }
            } else {
                $this->sorts[$name] = "asc";
            }
        }
    }

    private function getRows()
    {
        if (class_exists($this->model)) {
            $query = $this->model::query();
            $this->query = trim($this->query);
            $selects = [];

            foreach ($this->fields as $field) {
                if ($field["type"] == "field") {
                    $selects[] = $field["name"];
                }
                if ($this->queryable) {
                    if (isset($field["queryable"]) && $field["queryable"] == true && !empty($this->query)) {
                        $query->orWhere($field["name"], "like", "%" . $this->query . "%");
                    }
                }
            }

            if (count($selects) > 0) {
                $query->select($selects);
            }

            if ($this->sortable) {
                foreach (array_filter($this->sorts) as $key => $sort) {
                    if ($sort == "asc") {
                        $query->orderBy($key);
                    } else {
                        $query->orderByDesc($key);
                    }
                }
            }

            if ($this->pageable) {
                return $query->paginate($this->perPage);
            }

            return $query->get();
        } else {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, "Model doesn't exist: " . $this->model);
        }
    }

    public function paginationView()
    {
        return 'paksuco-table::pagination';
    }
}
