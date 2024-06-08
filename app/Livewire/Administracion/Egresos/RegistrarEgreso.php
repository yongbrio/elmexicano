<?php

namespace App\Livewire\Administracion\Egresos;

use App\Models\EgresosModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarEgreso extends Component
{
    public $codigo_egreso;
    public $categoria_1;
    public $categoria_2;
    public $tipo_egreso;
    public $descripcion_egreso;
    public $codigo_producto;
    public $unidad_medida;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.egresos.registrar-egreso');
    }

    public function registrarEgreso()
    {
        $this->validacionCampos();

        $egreso = EgresosModel::create([
            'codigo_egreso' => $this->codigo_egreso,
            'categoria_1' => $this->categoria_1,
            'categoria_2' => $this->categoria_2,
            'tipo_egreso' => $this->tipo_egreso,
            'descripcion_egreso' => $this->descripcion_egreso,
            'codigo_producto' => $this->codigo_producto,
            'unidad_medida' => $this->unidad_medida,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($egreso) {
            $message = "El Egreso ha sido creado con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
            $message = "Ha ocurrido un error, intente de nuevo";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'codigo_egreso' => 'required|integer',
            'categoria_1' => 'required|max:255',
            'categoria_2' => 'required|max:255',
            'tipo_egreso' => 'required',
            'descripcion_egreso' => 'required',
            'codigo_producto' => 'required|integer',
            'unidad_medida' => 'required',
            'estado' => 'required|string'
        ], [
            'codigo_egreso.required' => 'El código del egreso es obligatorio',
            'codigo_egreso.integer' => 'El código del egreso debe ser númerico',
            'categoria_1.required' => 'La categoría 1 es obligatoria',
            'categoria_2.required' => 'La categoría 2 es obligatoria',
            'tipo_egreso.required' => 'El tipo de egreso es obligatorio',
            'descripcion_egreso.required' => 'La descripción del egreso es obligatoria',
            'codigo_producto.required' => 'El código del prodcuto es obligatorio',
            'codigo_producto.integer' => 'El código del prodcuto debe ser númerico',
            'unidad_medida' => 'La unidad de medida es obligatoria',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarRegistrarEgreso()
    {
        return redirect()->route('admin-egresos');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-egresos');
    }
}
