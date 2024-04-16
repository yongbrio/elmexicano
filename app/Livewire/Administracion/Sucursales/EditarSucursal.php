<?php

namespace App\Livewire\Administracion\Sucursales;

use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarSucursal extends Component
{
    public $id;
    public $identificador;
    public $nombre_sucursal;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $estado;

    public function mount($id)
    {
        $this->id = $id;

        $sucursal = SucursalesModel::find($this->id);

        if ($sucursal) {

            $this->identificador = $sucursal->identificador;
            $this->nombre_sucursal = $sucursal->nombre_sucursal;
            $this->direccion  = $sucursal->direccion;
            $this->departamento = $sucursal->departamento;
            $this->ciudad = $sucursal->ciudad;
            $this->estado = $sucursal->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.sucursales.editar-sucursal');
    }

    public function actualizarSucursal()
    {
        $this->validacionCampos();

        $sucursal = SucursalesModel::find($this->id);

        if ($sucursal) {

            $sucursal->identificador = $this->identificador;
            $sucursal->nombre_sucursal = $this->nombre_sucursal;
            $sucursal->direccion = $this->direccion;
            $sucursal->departamento = $this->departamento;
            $sucursal->ciudad = $this->ciudad;
            $sucursal->estado = $this->estado;

            $actualizado = $sucursal->save();

            if ($actualizado) {
                $message = "La sucursal ha sido actualizada con éxito";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'identificador' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sucursales')->ignore($this->id)->where(function ($query) {
                    return $query->where('identificador', strtoupper($this->identificador));
                }),
            ],
            'nombre_sucursal' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|integer'
        ], [
            'identificador.required' => 'El identificador es obligatorio.',
            'identificador.unique' => 'El identificador ya existe.',
            'nombre_sucursal.required' => 'La sucursal es obligatoria.',
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarActualizarSucursal()
    {
        return redirect()->route('admin-sucursales');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-sucursales');
    }
}
