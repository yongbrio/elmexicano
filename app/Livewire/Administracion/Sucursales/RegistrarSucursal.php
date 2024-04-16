<?php

namespace App\Livewire\Administracion\Sucursales;

use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarSucursal extends Component
{

    public $identificador;
    public $nombre_sucursal;
    public $direccion;
    public $ciudad;
    public $departamento;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.sucursales.registrar-sucursal');
    }

    public function registrarSucursal()
    {
        $this->validacionCampos();

        $empresa = SucursalesModel::create([
            'identificador' => $this->identificador,
            'nombre_sucursal' => $this->nombre_sucursal,
            'direccion' => $this->direccion,
            'departamento' => $this->departamento,
            'ciudad' => $this->ciudad,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($empresa) {
            $message = "La sucursal ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'identificador' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sucursales')->where(function ($query) {
                    return $query->where('identificador', strtoupper($this->identificador));
                }),
            ],
            'nombre_sucursal' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|string'
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

    public function cancelarRegistrarSucursal()
    {
        return redirect()->route('admin-sucursales');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-sucursales');
    }
}
