<?php

namespace App\Livewire\Administracion\Egresos;

use App\Models\CategoriasEgresosAsociadasModel;
use App\Models\EgresosModel;
use App\Models\InventarioModel;
use App\Models\ProductosModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarEgreso extends Component
{
    public $categoria_1;
    public $categoria_2;
    public $tipo_egreso;
    public $descripcion_egreso;
    public $codigo_producto;
    public $unidad_medida;
    public $estado;
    public $codigo_egreso;
    public $flujo;
    public $listaProductos;
    public $codigo_producto_busqueda;
    public $lista_categorias_asociadas;

    public function mount()
    {
        // Obtener el próximo valor autoincrementable
        $this->codigo_egreso = $this->getNextAutoIncrementValue();
        Log::info($this->codigo_egreso);
        $this->flujo = 0;
    }

    public function render()
    {
        return view('livewire.administracion.egresos.registrar-egreso');
    }

    public function registrarEgreso()
    {

        if ($this->flujo == 2) {
            //REGULAR
            $this->codigo_producto = '';
            $this->unidad_medida = 0;
            $this->validacionCamposFlujo();
        } else if ($this->flujo == 1) {
            //INSUMO
            $this->validacionCampos();
        }

        $egreso = EgresosModel::create([
            'tipo_egreso' => $this->tipo_egreso,
            'categoria_1' => $this->categoria_1,
            'categoria_2' => $this->categoria_2,
            'descripcion_egreso' => $this->descripcion_egreso,
            'codigo_producto' => $this->codigo_producto ? $this->codigo_producto : NULL,
            'unidad_medida' => $this->unidad_medida ? $this->unidad_medida : 0,
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
            'categoria_1' => 'required|max:255',
            'categoria_2' => 'required|max:255',
            'tipo_egreso' => 'required',
            'codigo_producto' => 'required',
            'descripcion_egreso' => 'required',
            'unidad_medida' => 'required',
            'estado' => 'required|string'
        ], [
            'categoria_1.required' => 'La categoría 1 es obligatoria',
            'categoria_2.required' => 'La categoría 2 es obligatoria',
            'tipo_egreso.required' => 'El tipo de egreso es obligatorio',
            'codigo_producto.required' => 'El código del producto es obligatorio',
            'descripcion_egreso.required' => 'La descripción del egreso es obligatoria',
            'unidad_medida.required' => 'La unidad de medida es obligatoria',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function validacionCamposFlujo()
    {
        return  $this->validate([
            'categoria_1' => 'required|max:255',
            'categoria_2' => 'required|max:255',
            'descripcion_egreso' => 'required',
            'estado' => 'required|string'
        ], [
            'categoria_1.required' => 'La categoría 1 es obligatoria',
            'categoria_2.required' => 'La categoría 2 es obligatoria',
            'descripcion_egreso.required' => 'La descripción del egreso es obligatoria',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarRegistrarEgreso()
    {
        return redirect()->route('admin-egresos');
    }

    public function getNextAutoIncrementValue(): int
    {
        // Obtener el nombre de la base de datos actual
        $databaseName = DB::getDatabaseName();
        $table = "egresos";
        // Consulta para obtener el valor de autoincremento actual
        $result = DB::select("
            SELECT AUTO_INCREMENT
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = ?
        ", [$databaseName, $table]);

        // Retornar el valor de AUTO_INCREMENT
        return $result[0]->AUTO_INCREMENT;
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

    public function setearNombreProducto($id_producto, $nombre_producto)
    {
        $this->codigo_producto = $id_producto;
        $this->codigo_producto_busqueda = $nombre_producto;
        $this->listaProductos = '';
    }

    public function buscarProducto()
    {
        $this->codigo_producto = null;

        if (!empty($this->codigo_producto_busqueda)) {
            $this->listaProductos = ProductosModel::whereIn('tipo_producto', ['1', '2'])
                ->where('codigo_producto', 'LIKE', '%' . $this->codigo_producto_busqueda . '%')
                ->select('id', 'codigo_producto', 'descripcion')
                ->distinct()
                ->get();
        } else {
            $this->listaProductos = '';
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

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-egresos');
    }
}
