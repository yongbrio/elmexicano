<?php

namespace App\Livewire\Administracion\Empresas;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarEmpresa extends Component
{
    public $nit;
    public $nombreComercial;
    public $nombreLegal;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $matricula;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.empresas.registrar-empresa');
    }

    public function registrarEmpresa()
    {
        $this->validacionCampos();

        $empresa = EmpresasModel::create([
            'nit' => $this->nit,
            'nombre_comercial' => $this->nombreComercial,
            'nombre_legal' => $this->nombreLegal,
            'departamento' => $this->departamento,
            'ciudad' => $this->ciudad,
            'direccion' => $this->direccion,
            'matricula' => $this->matricula,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($empresa) {
            $message = "La empresa ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombreComercial' => 'required|string|max:255',
            'nombreLegal' => 'required|string|max:255',
            'nit' => 'required|string|max:20|unique:empresas,nit',  // Asumiendo que es una tabla de empresas
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'matricula' => 'required|string|max:255',
            'estado' => 'required|string'
        ], [
            'nombreComercial.required' => 'El nombre comercial es obligatorio.',
            'nombreLegal.required' => 'El nombre legal es obligatorio.',
            'nit.required' => 'El NIT es obligatorio.',
            'nit.unique' => 'El NIT ya está registrado.',
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'matricula.required' => 'La matrícula es obligatoria.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarRegistrarEmpresa()
    {
        return redirect()->route('admin-empresas');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-empresas');
    }
}
