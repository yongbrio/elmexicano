<?php

namespace App\Livewire\Utilidades\Cliente;

use App\Models\EmpresasModel;
use Livewire\Component;

class Empresa extends Component
{
    public $id;
    public $nombreComercial;
    public $nombreLegal;
    public $nit;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $matricula;

    public function mount($id)
    {
        $this->id = $id;

        $empresa = EmpresasModel::find($this->id);

        if ($empresa) {

            $this->nombreComercial = $empresa->nombre_comercial;
            $this->nombreLegal = $empresa->nombre_legal;
            $this->nit = $empresa->nit;
            $this->direccion = $empresa->direccion;
            $this->ciudad = $empresa->ciudad;
            $this->departamento = $empresa->departamento;
            $this->matricula = $empresa->matricula;
        }
    }

    public function render()
    {
        return view('livewire.utilidades.cliente.empresa');
    }
}
