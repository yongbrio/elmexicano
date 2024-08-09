<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonsComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $texto;
    public $icono;
    public $tipoBoton;
    public $wireAction;

    public function __construct($texto, $icono = null, $tipoBoton, $wireAction = null)
    {
        $this->texto = $texto;
        $this->icono = $icono;
        $this->tipoBoton = $tipoBoton;
        $this->wireAction = $wireAction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons-component');
    }
}
