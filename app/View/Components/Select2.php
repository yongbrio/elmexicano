<?php

namespace App\View\Components;

use App\Models\EmpresasModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2 extends Component
{

    public $label;
    public $id;
    public $icon;
    public $model;
    public $optionTextDefault;

    public $empresas;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $id, $icon, $model, $optionTextDefault)
    {
        $this->label = $label;
        $this->id = $id;
        $this->icon = $icon;
        $this->model = $model;
        $this->optionTextDefault = $optionTextDefault;
        $this->empresas = EmpresasModel::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select2');
    }

    public function obtenerEmpresas()
    {
    }
}
