<?php

namespace App\Livewire\Administracion\Proveedores;

use App\Models\DepartamentosModel;
use App\Models\LogModel;
use App\Models\MunicipiosModel;
use App\Models\ProveedoresModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarProveedor extends Component
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
    public $barrio_localidad;
    public $listaMunicipios;
    public $idciudad;
    public $iddepartamento;
    public $estado;

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

            $nombre_municipio = MunicipiosModel::where('id', $proveedor->ciudad)->first();
            $nombre_departamento = DepartamentosModel::where('id', $proveedor->departamento)->first();

            $this->idciudad = $proveedor->ciudad;
            $this->ciudad = $nombre_municipio->nombre_municipio;
            $this->departamento = $nombre_departamento->nombre_departamento;
            $this->correo = $proveedor->correo;
            $this->nombreEncargado = $proveedor->nombre_encargado;
            $this->descripcion = $proveedor->descripcion;
            $this->barrio_localidad = $proveedor->barrio_localidad;
            $this->estado = $proveedor->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.proveedores.editar-proveedor');
    }

    public function actualizarProveedor()
    {

        $this->validacionCampos();

        $proveedor = ProveedoresModel::find($this->id);

        if ($proveedor) {

            $proveedor->telefono = $this->telefono;
            $proveedor->grupo = $this->grupo;
            $proveedor->nombre_comercial = $this->nombreComercial;
            $proveedor->nombre_legal = $this->nombreLegal;
            $proveedor->nit = $this->nit;
            $proveedor->sucursal = $this->sucursal;
            $proveedor->direccion = $this->direccion;
            $proveedor->ciudad = $this->idciudad;
            $proveedor->departamento = $this->iddepartamento;
            $proveedor->correo = $this->correo;
            $proveedor->nombre_encargado = $this->nombreEncargado;
            $proveedor->descripcion = $this->descripcion;
            $proveedor->barrio_localidad = $this->barrio_localidad;
            $proveedor->estado = $this->estado;

            $actualizado = $proveedor->save();

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
            'telefono' => 'required|integer|unique:proveedores,telefono,' . $this->id,
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
            'barrio_localidad' => 'required|string|max:255',
            'estado' => 'required'
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
            'barrio_localidad.required' => 'El barrio o localidad es obligatorio.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarActualizarProveedor()
    {
        return redirect()->route('admin-proveedores');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-proveedores');
    }

    public function buscarCiudad()
    {
        if (!empty(trim($this->ciudad))) {

            $this->listaMunicipios = MunicipiosModel::where('nombre_municipio', 'like', '%' . $this->ciudad . '%')
                ->orderBy('nombre_municipio')
                ->take(5)
                ->get();

            $this->idciudad = null;
            $this->departamento = null;
            $this->iddepartamento = null;
        } else {

            $this->listaMunicipios = null;
        }
    }

    public function setearNombreCiudad($id)
    {
        $this->listaMunicipios = null;

        $nombreCiudad = MunicipiosModel::find($id);

        if ($nombreCiudad) {
            $this->ciudad = $nombreCiudad->nombre_municipio;
            $this->idciudad = $id;
            $departamento = DepartamentosModel::where('codigo_dane', $nombreCiudad->codigo_departamento)->first();
            $this->departamento = $departamento->nombre_departamento;
            $this->iddepartamento = $departamento->id;
        }
    }
}
