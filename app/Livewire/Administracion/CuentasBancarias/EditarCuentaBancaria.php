<?php

namespace App\Livewire\Administracion\CuentasBancarias;

use App\Models\CuentasBancariasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarCuentaBancaria extends Component
{

    public $id;
    public $tipo_cuenta;
    public $numero_cuenta;
    public $nombre_banco;
    public $empresa;
    public $fecha_apertura;
    public $estado;

    public function mount($id)
    {
        $this->id = $id;

        $cuenta = CuentasBancariasModel::find($this->id);

        if ($cuenta) {

            $this->tipo_cuenta = $cuenta->tipo_cuenta;
            $this->numero_cuenta = $cuenta->numero_cuenta;
            $this->nombre_banco = $cuenta->nombre_banco;
            $this->empresa = $cuenta->empresa;
            $this->fecha_apertura = $cuenta->fecha_apertura->format('Y-m-d');
            $this->estado = $cuenta->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.cuentas-bancarias.editar-cuenta-bancaria');
    }

    public function actualizarCuentaBancaria()
    {

        $this->validacionCampos();

        $cuenta = CuentasBancariasModel::find($this->id);

        if ($cuenta) {

            $cuenta->tipo_cuenta = $this->tipo_cuenta;
            $cuenta->numero_cuenta = $this->numero_cuenta;
            $cuenta->nombre_banco = $this->nombre_banco;
            $cuenta->empresa = $this->empresa;
            $cuenta->fecha_apertura = strtotime($this->fecha_apertura);
            $cuenta->estado = $this->estado;
            $cuenta->registrado_por = Auth::user()->id;

            $actualizado = $cuenta->save();

            if ($actualizado) {
                $message = "La cuenta bancaria se ha actualizado con éxito";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'tipo_cuenta' => 'required|string|max:255',
            'numero_cuenta' => 'required|integer|unique:cuentas_bancarias,numero_cuenta,' . $this->id, // Asumiendo que es una tabla de cuentas_bancarias
            'nombre_banco' => 'required|string|max:255',
            'empresa' => 'required|integer',
            'fecha_apertura' => 'required|date_format:Y-m-d',
            'estado' => 'required|integer'
        ], [
            'tipo_cuenta.required' => 'El tipo de cuenta es obligatorio.',
            'numero_cuenta.required' => 'El número de cuenta es obligatoria.',
            'numero_cuenta.unique' => 'La cuenta ya está registrada.',
            'nombre_banco.required' => 'El nombre del banco es obligatorio.',
            'empresa' => 'La empresa es obligatoria.',
            'fecha_apertura.required' => 'La fecha es obligatoria.',
            'fecha_apertura.date_format' => 'La fecha no tiene un formato valido.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarActualizarCuentaBancaria()
    {
        return redirect()->route('admin-cuentas-bancarias');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-cuentas-bancarias');
    }
}
