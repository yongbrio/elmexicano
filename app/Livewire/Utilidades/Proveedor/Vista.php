<?php

namespace App\Livewire\Utilidades\Proveedor;

use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
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
    public $barrio_localidad;
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
            $this->barrio_localidad = $proveedor->barrio_localidad;
            $this->direccion = $proveedor->direccion;

            $nombre_municipio = MunicipiosModel::where('id', $proveedor->ciudad)->first();
            $nombre_departamento = DepartamentosModel::where('id', $proveedor->departamento)->first();

            $this->ciudad = $nombre_municipio->nombre_municipio;
            $this->departamento = $nombre_departamento->nombre_departamento;

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
