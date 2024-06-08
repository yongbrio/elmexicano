<?php

namespace App\Livewire\Administracion\Egresos;

use App\Models\EgresosModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarEgreso extends Component
{
    public $id;
    public $codigo_egreso;
    public $categoria_1;
    public $categoria_2;
    public $tipo_egreso;
    public $descripcion_egreso;
    public $codigo_producto;
    public $unidad_medida;
    public $estado;


    public function mount($id)
    {
        $this->id = $id;

        $egreso = EgresosModel::find($this->id);

        if ($egreso) {

            $this->codigo_egreso = $egreso->codigo_egreso;
            $this->categoria_1 = $egreso->categoria_1;
            $this->categoria_2 = $egreso->categoria_2;
            $this->tipo_egreso = $egreso->tipo_egreso;
            $this->descripcion_egreso = $egreso->descripcion_egreso;
            $this->codigo_producto = $egreso->codigo_producto;
            $this->unidad_medida = $egreso->unidad_medida;
            $this->estado = $egreso->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.egresos.editar-egreso');
    }

    public function actualizarEgreso()
    {

        $this->validacionCampos();

        $egreso = EgresosModel::find($this->id);

        if ($egreso) {

            $egreso->codigo_egreso = $this->codigo_egreso;
            $egreso->categoria_1 = $this->categoria_1;
            $egreso->categoria_2 = $this->categoria_2;
            $egreso->tipo_egreso = $this->tipo_egreso;
            $egreso->descripcion_egreso = $this->descripcion_egreso;
            $egreso->codigo_producto = $this->codigo_producto;
            $egreso->unidad_medida = $this->unidad_medida;
            $egreso->estado = $this->estado;
            $egreso->registrado_por = Auth::user()->id;

            $actualizado = $egreso->save();

            if ($actualizado) {
                $message = "El egreso se ha actualizado con éxito";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
                $message = "No fue posible actualizar el egreso";
                $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
            }
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
            'estado' => 'required'
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

    public function cancelarActualizarEgreso()
    {
        $this->redirgir();
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-egresos');
    }
}
