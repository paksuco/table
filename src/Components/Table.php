<?php

namespace Paksuco\Table\Components;

use Illuminate\Database\Query\Expression;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Paksuco\Table\Contracts\TableSettings;

class Table extends Component
{
    use WithPagination;

    public $settings;

    public $updated;

    public $extras;

    public $request;

    protected $listeners = ['refresh'];

    public function mount(TableSettings $class, $extras = [])
    {
        $this->settings = $class;
        $this->extras   = $extras;
        $this->request  = [
            "route" => request()->route()->parameters,
            "query" => request()->input()
        ];
        $this->updated  = false;
    }

    public function refresh()
    {
        $this->updated = !$this->updated;
        $this->render();
    }

    public function hydrate()
    {
        /** @var \Paksuco\Table\Contracts\TableSettings */
        $class = $this->settings["class"];
        $this->settings = $class::fromArray($class, $this->settings);
    }

    public function dehydrate()
    {
        $this->settings = $this->settings->toArray();
    }

    public function render()
    {
        $this->settings->__construct();
        $rows = $this->getRows();
        $hasExtended = collect($this->settings->fields)->firstWhere("extended", true) !== null;

        return view("paksuco-table::components.table", [
            "rows" => $rows,
            "has_extended" => $hasExtended,
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
                        $query->orWhere(
                            DB::raw("LOWER(`" . implode("`.`", explode(".", $field["name"])) . "`)"),
                            "like",
                            "%" . strtolower($this->settings->query) . "%"
                        );
                    }
                }
            }

            if (count($this->settings->counts)) {
                $query->withCount($this->settings->counts);
            }

            if ($this->settings->trashed) {
                if ($class->hasGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope')) {
                    $query->withTrashed();
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

            if (method_exists($this->settings, "getFilters")) {
                $query->where($this->settings->getFilters($this->request));
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
                $paginator = new LengthAwarePaginator($rows, $total, $perPage, $currentPage);
                return $paginator;
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
        $tablesJoined = collect([$query->getModel()->getTable()]);

        if (empty($query->columns)) {
            $query->addSelect($query->getModel()->getTable() . ".*");
        }

        foreach ($relations as $relation) {
            /** @var \Illuminate\Database\Eloquent\Relations\Relation $relation */
            $relationInstance = $query->getModel()->$relation();
            $table = $relationInstance->getRelated()->getTable();
            $tableAlias = $relation;

            while ($tablesJoined->contains($tableAlias)) {
                $tableAlias = $tableAlias . "Parent";
            }

            if ($relationInstance instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
                /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo $relationInstance */
                $one = $relationInstance->getQualifiedOwnerKeyName();
                $two = $relationInstance->getQualifiedForeignKeyName();
                $one = str_replace("$table.", "$tableAlias.", $one);
            } else {
                $query->with($relation);
                continue;
            }

            foreach (Schema::getColumnListing($table) as $related_column) {
                $query->addSelect(new Expression("`$tableAlias`.`$related_column` AS `$tableAlias.$related_column`"));
            }

            $query->join(new Expression("$table as $tableAlias"), $one, "=", $two, "left");

            $tablesJoined->push($table);
        }
        //die($query->toSql());
        return $query;
    }
}
