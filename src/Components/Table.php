<?php

namespace Paksuco\Table\Components;

use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;
use Paksuco\Table\Contracts\TableCaster;
use Paksuco\Table\Contracts\TableSettings;

class Table extends Component
{
    use WithPagination;

    public $settings;

    protected $casts = [ 'settings' => '\Paksuco\Table\Contracts\TableCaster' ];

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
            $query = $this->settings->model::query();

            if (count($this->settings->relations) > 0) {
                $query->with($this->settings->relations);
            }

            $this->settings->query = trim($this->settings->query);
            $selects = [];

            foreach ($this->settings->fields as $field) {
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
                    if ($sort == "asc") {
                        $query->orderBy($key);
                    } else {
                        $query->orderByDesc($key);
                    }
                }
            }

            if ($this->settings->pageable) {
                return $query->paginate($this->settings->perPage);
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
}
