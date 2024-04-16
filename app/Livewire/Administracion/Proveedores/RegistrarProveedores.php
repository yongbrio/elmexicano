<?php

namespace App\Livewire\Administracion\Proveedores;

use App\Models\ProveedoresModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarProveedores extends Component
{
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
    public $estado;

    public function render()
    {
        return view('livewire.administracion.proveedores.registrar-proveedores');
    }

    public function registrarProveedor()
    {
        $this->validacionCampos();

        $proveedor = ProveedoresModel::create([
            'telefono' => $this->telefono,
            'grupo' => $this->grupo,
            'nombre_comercial' => $this->nombreComercial,
            'nombre_legal' => $this->nombreLegal,
            'nit' => $this->nit,
            'sucursal' => $this->sucursal,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudad,
            'departamento' => $this->departamento,
            'correo' => $this->correo,
            'nombre_encargado' => $this->nombreEncargado,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($proveedor) {
            $message = "El proveedor ha sido creado con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'telefono' => 'required|integer|unique:proveedores,telefono',
            'grupo' => 'required|string|max:255',
            'nombreComercial' => 'required|string|max:255',
            'nombreLegal' => 'required|string|max:255',
            'nit' => 'required|string|max:20',
            'sucursal' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'correo' => 'required|email|max:255',
            'nombreEncargado' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'estado' => 'required|string'
        ], [
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.integer' => 'El teléfono debe ser númerico.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'grupo.required' => 'El grupo es obligatorio.',
            'nombreComercial.required' => 'El nombre comercial es obligatorio.',
            'nombreLegal.required' => 'El nombre legal es obligatorio.',
            'nit.required' => 'El NIT es obligatorio.',
            'sucursal.required' => 'La sucursal es obligatoria.',
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección de email válida.',
            'direccion.required' => 'La dirección es obligatoria.',
            'nombreEncargado.required' => 'El nombre del encargado es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarRegistrarProveedor()
    {
        return redirect()->route('admin-proveedores');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-proveedores');
    }
}
