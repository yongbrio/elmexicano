<?php

namespace App\View\Components;

use App\Models\CategoriasModel;
use App\Models\EmpresasModel;
use App\Models\PerfilesModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\TipoProductoModel;
use App\Models\UnidadesMedidaModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class Select2 extends Component
{

    public $label;
    public $id;
    public $icon;
    public $model;
    public $optionTextDefault;
    public $idSucursalOrigen;

    /* Variables para las opciones de los select */
    public $empresas;
    public $categorias;
    public $sucursales;
    public $tipo_afectacion_impuesto;
    public $tipo_productos;
    public $unidad_medidas;
    public $wire;
    public $perfiles;
    public $sucursales_destino = null;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $id, $icon, $model, $optionTextDefault, $wire = null, $idSucursalOrigen = null)
    {
        $this->label = $label;
        $this->id = $id;
        $this->icon = $icon;
        $this->model = $model;
        $this->optionTextDefault = $optionTextDefault;
        $this->empresas = EmpresasModel::where('estado', 1)->get();
        $this->sucursales = SucursalesModel::where('estado', 1)->get();

        if (trim($idSucursalOrigen) != '' && $idSucursalOrigen) {
            $this->idSucursalOrigen = $idSucursalOrigen;
            $this->sucursales_destino = SucursalesModel::where('estado', 1)->where('id', '<>', $this->idSucursalOrigen)->get();
        }

        $this->tipo_productos = TipoProductoModel::all();
        $this->unidad_medidas = UnidadesMedidaModel::all();
        $this->categorias = CategoriasModel::where('estado', 1)->get();
        $this->tipo_afectacion_impuesto = TipoAfectacionImpuestoModel::where('estado', 1)->get();
        $this->wire = $wire;
        $this->perfiles = PerfilesModel::join('roles', 'perfiles.id_rol', '=', 'roles.id')->select('perfiles.*', 'roles.name as role_name', 'roles.id as role_id')
            ->where('perfiles.estado', 1)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select2');
    }
}
