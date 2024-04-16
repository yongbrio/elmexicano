<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LiveWireInput extends Component
{
    public $label;
    public $id;
    public $icon;
    public $placeholder;
    public $typeInput;
    public $model;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $id, $icon, $placeholder, $typeInput, $model = null,)
    {
        $this->label = $label;
        $this->id = $id;
        $this->icon = $icon;
        $this->model = $model;
        $this->placeholder = $placeholder;
        $this->typeInput = $typeInput;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.live-wire-input');
    }
}
