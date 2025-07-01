<?php

namespace App\Livewire\Administracion\Egresos;

use App\Models\CategoriasEgresosAsociadasModel;
use App\Models\EgresosModel;
use App\Models\InventarioModel;
use App\Models\ProductosModel;
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
    public $flujo;
    public $listaProductos;
    public $codigo_producto_busqueda;
    public $lista_categorias_asociadas;

    public function mount($id)
    {
        $this->id = $id;
        //Cargamos la relación con inventario
        $egreso = EgresosModel::with('codigoProducto')->find($this->id);

        if ($egreso) {
            $this->codigo_egreso = $egreso->id;
            $this->categoria_1 = $egreso->categoria_1;
            $this->traerCategoriasAsociadas();
            $this->categoria_2 = $egreso->categoria_2;
            $this->tipo_egreso = $egreso->tipo_egreso;
            $this->descripcion_egreso = $egreso->descripcion_egreso;
            $this->codigo_producto = $egreso->codigo_producto;
            $this->codigo_producto_busqueda = $egreso->codigoProducto
                ? $egreso->codigoProducto->codigo_producto . " - " . $egreso->codigoProducto->descripcion
                : null;
            $this->unidad_medida = $egreso->unidad_medida;
            $this->estado = $egreso->estado;

            if ($this->tipo_egreso == 1) {
                $this->flujo = 1;
            } else if ($this->tipo_egreso == 2) {
                $this->flujo = 2;
            }
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
        if ($this->flujo == 2) {
            //REGULAR
            $this->codigo_producto = null;
            $this->unidad_medida = 0;
            $this->validacionCamposFlujo();
        } else if ($this->flujo == 1) {
            //INSUMO
            $this->validacionCampos();
        }

        $egreso = EgresosModel::find($this->id);

        if ($egreso) {
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
        return $this->validate([
            'categoria_1' => 'required|max:255',
            'categoria_2' => 'required|max:255',
            'tipo_egreso' => 'required',
            'descripcion_egreso' => 'required',
            'codigo_producto' => 'required|integer',
            'unidad_medida' => 'required|not_in:0',
            'estado' => 'required'
        ], [
            'categoria_1.required' => 'La categoría 1 es obligatoria',
            'categoria_2.required' => 'La categoría 2 es obligatoria',
            'tipo_egreso.required' => 'El tipo de egreso es obligatorio',
            'descripcion_egreso.required' => 'La descripción del egreso es obligatoria',
            'codigo_producto.required' => 'El código del producto es obligatorio',
            'codigo_producto.integer' => 'El código del producto debe ser númerico',
            'unidad_medida' => 'La unidad de medida es obligatoria',
            'unidad_medida.not_in' => 'La unidad de medida es obligatoria',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function validacionCamposFlujo()
    {
        return  $this->validate([
            'categoria_1' => 'required|max:255',
            'categoria_2' => 'required|max:255',
            'descripcion_egreso' => 'required',
            'estado' => 'required'
        ], [
            'categoria_1.required' => 'La categoría 1 es obligatoria',
            'categoria_2.required' => 'La categoría 2 es obligatoria',
            'descripcion_egreso.required' => 'La descripción del egreso es obligatoria',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function seleccionarFlujo()
    {
        if ($this->tipo_egreso == 1) {
            //INSUMO
            $this->flujo = 1;
        } else if ($this->tipo_egreso == 2) {
            //REGULAR
            $this->flujo = 2;
        } else {
            //SIN SELECCIÓN
            $this->flujo = 0;
        }
    }

    public function traerCategoriasAsociadas()
    {
        if ($this->categoria_1) {
            $this->lista_categorias_asociadas = CategoriasEgresosAsociadasModel::with('categoria2') // Carga la relación
                ->where('id_categoria_1', $this->categoria_1)
                ->get();
        } else {
            $this->lista_categorias_asociadas = null;
        }
    }

    public function buscarProducto()
    {
        $this->codigo_producto = null;

        if (!empty($this->codigo_producto_busqueda)) {
            $this->listaProductos = ProductosModel::where(function ($query) {
                $query->where('descripcion', 'like', '%' . $this->codigo_producto_busqueda . '%')
                    ->orWhere('codigo_producto', 'like', '%' . $this->codigo_producto_busqueda . '%');
            })
                ->where('estado', 1)
                ->orderBy('codigo_producto')
                ->take(5)
                ->get();
        } else {
            $this->listaProductos = '';
        }
    }

    public function setearNombreProducto($id_producto, $nombre_producto)
    {
        $this->codigo_producto = $id_producto;
        $this->codigo_producto_busqueda = $nombre_producto;
        $this->listaProductos = '';
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
