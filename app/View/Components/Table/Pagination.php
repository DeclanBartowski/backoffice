<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $field;
    public $sort;
    public $page;
    public $route;
    public $paramsRoute;
    public $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field, $sort, $data, $route, $paramsRoute = [])
    {
        $this->field = $field;
        $this->sort = $sort;
        $this->page = $data->currentPage();
        $this->route = $route;
        $this->paramsRoute = $paramsRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.pagination');
    }
}
