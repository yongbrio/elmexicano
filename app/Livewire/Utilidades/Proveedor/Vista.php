<?php

namespace App\Livewire\Utilidades\Proveedor;

use App\Models\ProveedoresModel;
use Livewire\Component;

class Vista extends Component
{
    public $id;
    public $telefono;
    public $grupo;
    public $nombreComercial;
    public $nombreLegal;
    public $nit;
    public $sucursal;
    public $direccion;
    public $ciudad;
    public $departamento;
    public $correo;
    public $nombreEncargado;
    public $descripcion;

    public function mount($id)
    {
        $this->id = $id;

        $proveedor = ProveedoresModel::find($this->id);

        if ($proveedor) {

            $this->telefono = $proveedor->telefono;
            $this->grupo = $proveedor->grupo;
            $this->nombreComercial = $proveedor->nombre_comercial;
            $this->nombreLegal = $proveedor->nombre_legal;
            $this->nit = $proveedor->nit;
            $this->sucursal = $proveedor->sucursal;
            $this->direccion = $proveedor->direccion;
            $this->ciudad = $proveedor->ciudad;
            $this->departamento = $proveedor->departamento;
            $this->correo = $proveedor->correo;
            $this->nombreEncargado = $proveedor->nombre_encargado;
            $this->descripcion = $proveedor->descripcion;
        }
    }


    public function render()
    {
        return view('livewire.utilidades.proveedor.vista');
    }
}
