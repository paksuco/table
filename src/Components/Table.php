<?php

namespace Paksuco\Table\Components;

use Illuminate\Database\Query\Expression;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;
use Paksuco\Table\Contracts\TableSettings;

class Table extends Component
{
    use WithPagination;

    public $settings;

    protected $casts = ['settings' => '\Paksuco\Table\Contracts\TableCaster'];

    public function mount(TableSettings $class)
    {
        $this->settings = $class;
    }

    public function render()
    {
        $rows = $this->getRows();

        return view("paksuco-table::components.table", [
            "rows" => $rows,
            // "settings" => $this->settings
        ]);
    }

    public function toggleSort($name)
    {
        if (array_key_exists($name, $this->settings->sorts) == true) {
            switch ($this->settings->sorts[$name]) {
                case null:
                    $this->settings->sorts[$name] = "asc";
                    break;
                case "asc":
                    $this->settings->sorts[$name] = "desc";
                    break;
                case "desc":
                    $this->settings->sorts[$name] = null;
                    break;
                default:
                    $this->settings->sorts[$name] = "asc";
                    break;
            }
        } else {
            $this->settings->sorts[$name] = "asc";
        }
        $this->render();
    }

    public function setPerPage($perPage)
    {
        $this->settings->perPage = $perPage;
    }

    private function getRows()
    {
        if (class_exists($this->settings->model)) {
            $class = new $this->settings->model;
            $hasRelations = false;

            /** @var \Illuminate\Database\Eloquent\Model $query  */
            $query = $class::query();
            $table = $query->getModel()->getTable();

            if (count($this->settings->relations) > 0) {
                $query = $this->addRelationJoins($query, $this->settings->relations);
                $hasRelations = true;
            }

            $this->settings->query = trim($this->settings->query);
            $selects = [];

            foreach ($this->settings->fields as $field) {
                if ($hasRelations == true && strpos($field["name"], ".") === false) {
                    $field["name"] = $table . "." . $field["name"];
                }
                if ($field["type"] == "field") {
                    $selects[] = $field["name"];
                }
                if ($this->settings->queryable) {
                    if (isset($field["queryable"]) && $field["queryable"] == true &&
                        !empty($this->settings->query)) {
                        $query->orWhere($field["name"], "like", "%" . $this->settings->query . "%");
                    }
                }
            }

            if ($this->settings->sortable) {
                foreach (array_filter($this->settings->sorts) as $key => $sort) {
                    if ($hasRelations && strpos($key, ".") === false) {
                        $key = $table . "." . $key;
                    }
                    if ($sort == "asc") {
                        $query->orderBy($key);
                    } else {
                        $query->orderByDesc($key);
                    }
                }
            }

            if ($this->settings->pageable) {
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = $this->settings->perPage;
                $total = $query->count("$table.id");
                $offset = $perPage * ($currentPage - 1);
                if ($offset > $total) {
                    $currentPage = 1;
                    $offset = 0;
                }
                $rows = $query->offset($offset)->limit($perPage)->get();
                return new LengthAwarePaginator($rows, $total, $perPage, $currentPage);
                // return $query->paginate($this->settings->perPage);
            }

            return $query->get();
        } else {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, "Model doesn't exist: " . $this->settings->model);
        }
    }

    public function paginationView()
    {
        return 'paksuco-table::pagination';
    }

    public function addRelationJoins($query, $relations)
    {
        if (empty($query->columns)) {
            $query->addSelect($query->getModel()->getTable() . ".*");
        }

        foreach ($relations as $relation) {
            /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo $relation */
            $relation = $query->getModel()->$relation();
            $table = $relation->getRelated()->getTable();
            $one = $relation->getQualifiedOwnerKeyName();
            $two = $relation->getQualifiedForeignKeyName();

            foreach (Schema::getColumnListing($table) as $related_column) {
                $query->addSelect(new Expression("`$table`.`$related_column` AS `$table.$related_column`"));
            }

            $query->join($table, $one, "=", $two, "left");
        }

        return $query;
    }
}
