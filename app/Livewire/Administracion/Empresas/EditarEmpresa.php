<?php

namespace App\Livewire\Administracion\Empresas;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarEmpresa extends Component
{
    public $id;
    public $nombreComercial;
    public $nombreLegal;
    public $nit;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $matricula;
    public $estado;

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
            $this->estado = $empresa->estado;
        } else {
            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.empresas.editar-empresa');
    }

    public function actualizarEmpresa()
    {

        $this->validacionCampos();

        $empresa = EmpresasModel::find($this->id);

        if ($empresa) {

            $empresa->nit = $this->nit;
            $empresa->nombre_comercial = $this->nombreComercial;
            $empresa->nombre_legal = $this->nombreLegal;
            $empresa->departamento = $this->departamento;
            $empresa->ciudad = $this->ciudad;
            $empresa->direccion = $this->direccion;
            $empresa->matricula = $this->matricula;
            $empresa->estado = $this->estado;
            $empresa->registrado_por = Auth::user()->id;

            $actualizado = $empresa->save();

            if ($actualizado) {
                $message = "La empresa se ha actualizado con éxito";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombreComercial' => 'required|string|max:255',
            'nombreLegal' => 'required|string|max:255',
            'nit' => 'required|string|max:20|unique:empresas,nit,' . $this->id,  // Asumiendo que es una tabla de empresas
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'matricula' => 'required|string|max:255',
            'estado' => 'required|integer'
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

    public function cancelarActualizarEmpresa()
    {
        $this->redirgir();
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-empresas');
    }
}
