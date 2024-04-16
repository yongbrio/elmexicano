<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DatePickerInput extends Component
{
    public $label;
    public $id;
    public $placeholder;
    public $model;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $id, $placeholder, $model)
    {
        $this->label = $label;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.date-picker-input');
    }
}
