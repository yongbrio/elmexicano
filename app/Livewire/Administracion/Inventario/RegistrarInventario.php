<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\InventarioModel;
use App\Models\ProductosModel;
use App\Models\TipoAfectacionImpuestoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistrarInventario extends Component
{
    use WithFileUploads;

    public $categoria;
    public $tipo;
    public $impuesto;
    public $codigo_producto;
    public $descripcion;
    public $unidad_medida;
    public $costo_unitario;
    public $precio_unitario_con_iva;
    public $precio_unitario_sin_iva;
    public $stock;
    public $stock_minimo;
    public $comisiona;
    public $estado;
    public $tipoSeleccionado;
    public $sucursal;
    public $comision;
    public $tipo_producto;
    #[Validate('image')]
    public $imagen_db;
    public $listaProductos;
    public $id_producto;

    public function render()
    {
        return view('livewire.administracion.inventario.registrar-inventario');
    }

    public function validarCodigoProducto()
    {
        if (trim($this->id_producto) != '' && trim($this->sucursal) != '') {
            $codigo_producto_sucursal = InventarioModel::where('producto_id', $this->id_producto)->where('sucursal_id', $this->sucursal)->exists();
            if ($codigo_producto_sucursal) {
                $this->reset();
                $message = "El código de producto ya existe en la sucursal seleccionada";
                $elementId = "codigo_producto";
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                $this->cambioImagen();
                $this->dispatch('resetFileInput');
                return false;
            } else {
                return true;
            }
        }
    }

    public function registrarInventario()
    {
        $this->validacionCampos();

        $insertarInventario = InventarioModel::Create(
            [
                'producto_id' => $this->id_producto,
                'sucursal_id' => $this->sucursal,
                'stock' => $this->stock,
                'stock_minimo' => $this->stock_minimo,
                'registrado_por' => Auth::user()->id,
                'comisiona' => $this->comisiona,
                'estado' => $this->estado,
            ]
        );

        if ($insertarInventario) {
            $message = "El producto se ha registrado correctamente en el inventario.";
            $this->dispatch('estadoActualizacion', title: "Registrado", icon: 'success', message: $message);
        } else {
            $message = "El producto NO se ha registrado correctamente en el inventario.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        }
    }

    public function cambioImagen()
    {
        $this->imagen_db = null;
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'sucursal' => 'required',
            'codigo_producto' => [
                'required',
                Rule::unique('inventario', 'producto_id')
                    ->where(fn($query) => $query->where('sucursal_id', $this->sucursal))
            ],
            'stock' => 'required',
            'stock_minimo' => 'required',
            'comisiona' => 'required',
            'estado' => 'required'
        ], [
            'sucursal.required' => 'La sucursal es requerida',
            'codigo_producto.required' => 'El código del producto es requerido',
            'codigo_producto.unique' => 'El código del producto ya existe',
            'stock.required' => 'El Stock es requerido',
            'stock_minimo.required' => 'El Stock mínimo es requerido',
            'comisiona.required' => 'Comisiona es requerida',
            'estado.required' => 'El estado es requerido',
        ]);
    }

    public function buscarProducto()
    {
        $this->listaProductos = ProductosModel::where(function ($query) {
            $query->where('descripcion', 'like', '%' . $this->codigo_producto . '%')
                ->orWhere('codigo_producto', 'like', '%' . $this->codigo_producto . '%');
        })
            ->where('estado', 1)
            ->orderBy('codigo_producto')
            ->take(5)
            ->get();

        $this->id_producto = null;
        $this->cambioImagen();
        $this->categoria = null;
        $this->tipo_producto = null;
        $this->descripcion = null;
        $this->unidad_medida = null;
        $this->tipo = null;
        $this->impuesto = null;
        $this->costo_unitario = null;
        $this->precio_unitario_con_iva = null;
        $this->precio_unitario_sin_iva = null;
        $this->comision = null;
    }

    public function setearNombreProducto($id)
    {
        $this->listaProductos = null;
        $this->id_producto = $id;

        if ($this->validarCodigoProducto()) {
            $producto = ProductosModel::find($id);

            if ($producto) {

                $this->codigo_producto = $producto->codigo_producto;
                $this->categoria = $producto->categoria;
                $this->tipo_producto = $producto->tipo_producto;
                $this->descripcion = $producto->descripcion;
                $this->unidad_medida = $producto->unidad_medida;
                $this->tipo = $producto->tipo_impuesto;
                $this->impuesto = $producto->tipoImpuesto?->impuesto;
                $this->costo_unitario = $producto->costo_unitario;
                $this->precio_unitario_con_iva = $producto->precio_unitario_con_iva;
                $this->precio_unitario_sin_iva = $producto->precio_unitario_sin_iva;
                $this->comision = $producto->comision;
                $this->imagen_db = $producto->imagen;
            }
        }
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-inventario');
    }

    public function cancelarRegistrarInventario()
    {
        return redirect()->route('admin-inventario');
    }
}
