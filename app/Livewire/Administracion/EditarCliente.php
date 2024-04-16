<?php

namespace App\Livewire\Administracion;

use App\Models\ClientesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarCliente extends Component
{
    public $id;
    public $nombreComercial;
    public $nombreLegal;
    public $grupo;
    public $telefono;
    public $nit;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $sucursal;
    public $correo;
    public $nombreEncargado;
    public $descripcion;
    public $empresaFactura;
    public $importancia;
    public $estado;

    public function mount($id)
    {
        $this->id = $id;

        $cliente = ClientesModel::find($this->id);

        if ($cliente) {

            $this->nombreComercial = $cliente->nombre_comercial;
            $this->nombreLegal = $cliente->nombre_legal;
            $this->grupo = $cliente->grupo;
            $this->telefono = $cliente->telefono;
            $this->nit = $cliente->nit;
            $this->sucursal = $cliente->sucursal;
            $this->direccion = $cliente->direccion;
            $this->ciudad = $cliente->ciudad;
            $this->departamento = $cliente->departamento;
            $this->correo = $cliente->correo;
            $this->nombreEncargado = $cliente->nombre_encargado;
            $this->descripcion = $cliente->descripcion;
            $this->empresaFactura = $cliente->empresa_factura;
            $this->importancia = $cliente->importancia;
            $this->estado = $cliente->estado;
            
        } else {
            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.editar-cliente');
    }

    public function actualizarCliente()
    {

        $this->validacionCampos();

        $cliente = ClientesModel::find($this->id);

        if ($cliente) {

            $cliente->nombre_comercial = $this->nombreComercial;
            $cliente->nombre_legal = $this->nombreLegal;
            $cliente->grupo = $this->grupo;
            $cliente->telefono = $this->telefono;
            $cliente->nit = $this->nit;
            $cliente->sucursal = $this->sucursal;
            $cliente->direccion = $this->direccion;
            $cliente->ciudad = $this->ciudad;
            $cliente->departamento = $this->departamento;
            $cliente->correo = $this->correo;
            $cliente->nombre_encargado = $this->nombreEncargado;
            $cliente->descripcion = $this->descripcion;
            $cliente->empresa_factura = $this->empresaFactura;
            $cliente->importancia = $this->importancia;
            $cliente->estado = $this->estado;
            $cliente->registrado_por = Auth::user()->id;

            $actualizado = $cliente->save();

            if ($actualizado) {
                $message = "El cliente se ha actualizado con éxito";
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
            'grupo' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'nit' => 'required|string|max:20|unique:clientes,nit,' . $this->id,  // Asumiendo que es una tabla de clientes
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'sucursal' => 'required|string|max:100',
            'correo' => 'required|email|max:255',
            'nombreEncargado' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'empresaFactura' => 'required|string|max:255',
            'importancia' => 'required|string',
            'estado' => 'required|integer'
        ], [
            'nombreComercial.required' => 'El nombre comercial es obligatorio.',
            'nombreLegal.required' => 'El nombre legal es obligatorio.',
            'grupo.required' => 'El grupo es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.integer' => 'El teléfono debe ser númerico.',
            'nit.required' => 'El NIT es obligatorio.',
            'nit.unique' => 'El NIT ya está registrado.',
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
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

    public function cancelarActualizarCliente()
    {
        $this->redirgir();
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-clientes');
    }
}
