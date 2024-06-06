<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\InventarioModel;
use App\Models\TipoAfectacionImpuestoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarInventario extends Component
{
    use WithFileUploads;

    public $id;
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
    public $estado;
    public $tipoSeleccionado;
    public $sucursal;
    public $sucursal_actual;
    public $comision;
    public $tipo_producto;
    #[Validate('image')]
    public $imagen;
    public $imagen_db;

    public function mount($id)
    {
        $this->id = $id;

        $inventario = InventarioModel::find($this->id);

        if ($inventario) {

            $this->categoria = $inventario->categoria;
            $this->tipo = $inventario->tipo;
            $impuesto = TipoAfectacionImpuestoModel::where('id', $this->tipo)->first();
            $this->impuesto = $impuesto->impuesto;
            $this->codigo_producto = $inventario->codigo_producto;
            $this->descripcion = $inventario->descripcion;
            $this->unidad_medida = $inventario->unidad_medida;
            $this->costo_unitario = $inventario->costo_unitario;
            $this->precio_unitario_con_iva = $inventario->precio_unitario_con_iva;
            $this->precio_unitario_sin_iva = $inventario->precio_unitario_sin_iva;
            $this->stock_minimo = $inventario->stock_minimo;
            $this->estado = $inventario->estado;
            $this->tipoSeleccionado = $inventario->tipoSeleccionado;
            $this->imagen_db = $inventario->imagen;
            $this->estado = $inventario->estado;
            $this->stock = $inventario->stock;
            $this->comision = $inventario->comision;
            $this->tipo_producto = $inventario->tipo_producto;
            $this->sucursal = $inventario->sucursal;
            $this->sucursal_actual = $inventario->sucursal;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.inventario.editar-inventario');
    }

    public function asignarPorcentaje()
    {
        $tipo_afectacion_impuesto = TipoAfectacionImpuestoModel::where('id', $this->tipo)->first();

        if ($tipo_afectacion_impuesto) {
            $this->impuesto = $tipo_afectacion_impuesto->impuesto;
            $this->validarTipoAfectacion();
        } else {
            $this->precio_unitario_con_iva = '';
            $this->precio_unitario_sin_iva = '';
            $this->impuesto = 0;
        }
    }

    public function validarTipoAfectacion()
    {
        if ($this->tipo == '') {
            $message = "Seleccione el tipo de afectación";
            $elementId = "precio_unitario_con_iva";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        } else {

            $tipo_afectacion_impuesto = TipoAfectacionImpuestoModel::where('id', $this->tipo)->first();

            $tarifa  = 0;

            if ($tipo_afectacion_impuesto) {
                $tarifa =  $tipo_afectacion_impuesto->impuesto;
            }

            if ($this->precio_unitario_con_iva == '') {
                $this->precio_unitario_sin_iva = '';
            } else {
                //validar si precio_unitario es número antes de realizar la operación
                $this->precio_unitario_sin_iva = number_format(($this->precio_unitario_con_iva  / ($tarifa / 100 + 1)), 2, '.', '');
            }
        }
    }

    public function validarCodigoProducto()
    {
        if (trim($this->codigo_producto) != '' && trim($this->sucursal) != '') {

            $codigo_producto_sucursal = InventarioModel::where('codigo_producto', $this->codigo_producto)->where('sucursal', '<>', $this->sucursal_actual)->exists();

            if ($codigo_producto_sucursal) {
                $message = "El código de producto ya existe en la sucursal seleccionada";
                $elementId = "sucursal";
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                $this->sucursal = $this->sucursal_actual;
            }
        }
    }

    public function actualizarInventario()
    {

        $this->validacionCampos();
        $rutaImagen = "";
        if ($this->imagen) {
            // Cambiamos el nombre de la imagen
            $extension = $this->imagen->extension();
            $nombreArchivo = $this->codigo_producto . "." . $extension;
            $rutaImagen = $this->imagen->storeAs('imagenes/productos', $nombreArchivo);
        }

        $inventario = InventarioModel::find($this->id);

        if ($inventario) {

            $inventario->categoria = $this->categoria;
            $inventario->descripcion = $this->descripcion;
            $inventario->tipo = $this->tipo;
            $inventario->unidad_medida = $this->unidad_medida;
            $inventario->costo_unitario = $this->costo_unitario;
            $inventario->precio_unitario_con_iva = $this->precio_unitario_con_iva;
            $inventario->precio_unitario_sin_iva = $this->precio_unitario_sin_iva;
            $inventario->stock = $this->stock_minimo;
            $inventario->stock_minimo = $this->stock_minimo;
            if (!$this->imagen_db && $this->imagen) {
                $inventario->imagen = "$rutaImagen";
            } else if (!$this->imagen_db && !$this->imagen) {
                $inventario->imagen = "$rutaImagen";
            }
            $inventario->registrado_por = Auth::user()->id;
            $inventario->estado = $this->estado;

            $inventario->stock = $this->stock;
            $inventario->comision = $this->comision;
            $inventario->tipo_producto = $this->tipo_producto;
            $inventario->sucursal = $this->sucursal;

            $actualizarInventario = $inventario->save();

            if ($actualizarInventario) {
                $message = "El producto se ha actualizado correctamente en el inventario.";
                $this->dispatch('estadoActualizacion', title: "Registrado", icon: 'success', message: $message);
            } else {
                $message = "El producto NO se ha actualizado correctamente en el inventario.";
                $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
            }
        }
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'image' // Validar la imagen
        ], [
            'imagen.image' => 'El archivo debe ser una imagen.',
        ]);
    }

    public function cambioImagen()
    {
        $this->imagen = null;
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'categoria' => 'required',
            'tipo' => 'required',
            'sucursal' => 'required',
            'comision' => 'required',
            'impuesto' => 'required',
            'codigo_producto' => ['required'],
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'tipo_producto' => 'required',
            'precio_unitario_con_iva' => 'required',
            'precio_unitario_sin_iva' => 'required',
            'costo_unitario' => 'required',
            'stock' => 'required',
            'stock_minimo' => 'required',
            'estado' => 'required'
        ], [
            'categoria.required' => 'La categoría es requerida',
            'tipo.required' => 'El tipo de impuesto es requerido',
            'sucursal.required' => 'La sucursal es requerida',
            'comision.required' => 'La comisión es requerida',
            'impuesto.required' => 'El impuesto es requerido',
            'codigo_producto.required' => 'El código del producto es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'unidad_medida.required' => 'La unidad de medida es requerida',
            'tipo_producto.required' => 'El tipo de producto es requerido',
            'precio_unitario_con_iva.required' => 'El precio con IVA es requerido',
            'precio_unitario_sin_iva.required' => 'El precio sin IVA es requerido',
            'costo_unitario.required' => 'El costo unitario es requerido',
            'stock.required' => 'El Stock es requerido',
            'stock_minimo.required' => 'El Stock mínimo es requerido',
            'estado.required' => 'El estado es requerido',
        ]);
    }

    public function eliminarImagen()
    {
        $this->imagen_db = null;
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-inventario');
    }

    public function cancelarActualizarInventario()
    {
        return redirect()->route('admin-inventario');
    }
}
