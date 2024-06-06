<?php

namespace App\Livewire\Administracion;

use App\Models\ClientesModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrarClientes extends Component
{

    public $nombreComercial;
    public $nombreLegal;
    public $grupo;
    public $telefono;
    public $nit;
    public $departamento;
    public $iddepartamento;
    public $ciudad;
    public $idciudad;
    public $direccion;
    public $sucursal;
    public $correo;
    public $nombreEncargado;
    public $descripcion;
    public $empresaFactura;
    public $importancia;
    public $estado;
    public $listaMunicipios;

    public function render()
    {
        return view('livewire.administracion.registrar-clientes');
    }

    public function registrarCliente()
    {
        $this->validacionCampos();

        $cliente = ClientesModel::create([
            'nombre_comercial' => $this->nombreComercial,
            'nombre_legal' => $this->nombreLegal,
            'grupo' => $this->grupo,
            'telefono' => $this->telefono,
            'nit' => $this->nit,
            'sucursal' => $this->sucursal,
            'direccion' => $this->direccion,
            'ciudad' => $this->idciudad,
            'departamento' => $this->iddepartamento,
            'correo' => $this->correo,
            'nombre_encargado' => $this->nombreEncargado,
            'descripcion' => $this->descripcion,
            'empresa_factura' => $this->empresaFactura,
            'importancia' => $this->importancia,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($cliente) {
            $message = "El cliente ha sido creado con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombreComercial' => 'required|string|max:255',
            'nombreLegal' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'nit' => 'required|string|max:20|unique:clientes,nit',  // Asumiendo que es una tabla de clientes
            'iddepartamento' => 'required',
            'idciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'sucursal' => 'required|string|max:100',
            'correo' => 'required|email|max:255',
            'nombreEncargado' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'empresaFactura' => 'required|string|max:255',
            'importancia' => 'required|string',
            'estado' => 'required|string'
        ], [
            'nombreLegal.required' => 'El nombre legal es obligatorio.',
            'nombreComercial.required' => 'El nombre comercial es obligatorio.',
            'grupo.required' => 'El grupo es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.integer' => 'El teléfono debe ser númerico.',
            'nit.required' => 'El NIT es obligatorio.',
            'nit.unique' => 'El NIT ya está registrado.',
            'iddepartamento.required' => 'El departamento es obligatorio.',
            'idciudad.required' => 'La ciudad es obligatoria.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección de email válida.',
            'direccion.required' => 'La dirección es obligatoria.',
            'sucursal.required' => 'La sucursal es obligatoria.',
            'nombreEncargado.required' => 'El nombre del encargado es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'empresaFactura.required' => 'No seleccionó con que empresa factura.',
            'importancia.required' => 'La importancia es obligatoria.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarRegistrarCliente()
    {
        return redirect()->route('admin-clientes');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-clientes');
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
