<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToggleSwitchLi extends Component
{
    /**
     * Create a new component instance.
     */

    public $nombreModulo;
    public $wire;
    public $activate;
    public $id;

    public function __construct($nombreModulo, $wire, $activate, $id)
    {
        $this->nombreModulo = $nombreModulo;
        $this->wire = $wire;
        $this->activate = $activate;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggle-switch-li');
    }
}
