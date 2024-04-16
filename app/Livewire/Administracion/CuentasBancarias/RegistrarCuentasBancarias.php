<?php

namespace App\Livewire\Administracion\CuentasBancarias;

use App\Models\CuentasBancariasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarCuentasBancarias extends Component
{

    public $tipo_cuenta;
    public $numero_cuenta;
    public $nombre_banco;
    public $empresa;
    public $fecha_apertura;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.cuentas-bancarias.registrar-cuentas-bancarias');
    }

    public function registrarCuentaBancaria()
    {
        $this->validacionCampos();
        $empresa = CuentasBancariasModel::create([
            'tipo_cuenta' => $this->tipo_cuenta,
            'numero_cuenta' => $this->numero_cuenta,
            'nombre_banco' => $this->nombre_banco,
            'fecha_apertura' => strtotime($this->fecha_apertura),
            'empresa' => $this->empresa,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($empresa) {
            $message = "La cuenta bancaria ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'tipo_cuenta' => 'required|string|max:255',
            'numero_cuenta' => 'required|integer|unique:cuentas_bancarias,numero_cuenta', // Asumiendo que es una tabla de cuentas_bancarias
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

    public function cancelarRegistrarCuentaBancaria()
    {
        return redirect()->route('admin-cuentas-bancarias');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-cuentas-bancarias');
    }
}
