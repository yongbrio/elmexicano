<?php

namespace App\View\Components;

use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */

    public $sucursal;

    public function render(): View
    {
        $sucursalId = Auth::user()->caja;
        $this->sucursal = SucursalesModel::find($sucursalId);
        return view('layouts.app'/* , ['sucursal' => $this->sucursal] */);
    }
}
