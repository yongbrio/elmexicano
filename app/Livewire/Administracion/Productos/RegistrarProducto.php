<?php

namespace App\Livewire\Administracion\Productos;

use App\Models\ProductosModel;
use App\Models\TipoAfectacionImpuestoModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;


class RegistrarProducto extends Component
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
    public $estado;
    public $tipoSeleccionado;
    public $comision;
    public $tipo_producto;
    #[Validate('image')]
    public $imagen;

    public function render()
    {
        return view('livewire.administracion.productos.registrar-producto');
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
        if (trim($this->codigo_producto) != '') {

            $codigo_producto_existe = ProductosModel::where('codigo_producto', $this->codigo_producto)->exists();

            if ($codigo_producto_existe) {
                $message = "El código de producto ya existe";
                $elementId = "codigo_producto";
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                $this->reset();
                $this->cambioImagen();
                $this->dispatch('resetFileInput');
            }
        }
    }

    public function registrarProducto()
    {

        $this->validacionCampos();

        $rutaImagen = "";
        if ($this->imagen) {
            // Cambiamos el nombre de la imagen
            $extension = $this->imagen->extension();
            $nombreArchivo = $this->codigo_producto . "." . $extension;
            $rutaImagen = $this->imagen->storeAs('imagenes/productos', $nombreArchivo);
        }

        $insertarProducto = ProductosModel::Create(
            [
                'codigo_producto' => $this->codigo_producto,
                'comision' => $this->comision,
                'categoria' => $this->categoria,
                'tipo_impuesto' => $this->tipo,
                'descripcion' => $this->descripcion,
                'unidad_medida' => $this->unidad_medida,
                'tipo_producto' => $this->tipo_producto,
                'costo_unitario' => $this->costo_unitario,
                'precio_unitario_con_iva' => $this->precio_unitario_con_iva,
                'precio_unitario_sin_iva' => $this->precio_unitario_sin_iva,
                'imagen' => "$rutaImagen",
                'registrado_por' => Auth::user()->id,
                'estado' => $this->estado,
            ]
        );

        if ($insertarProducto) {
            $message = "El producto se ha registrado correctamente.";
            $this->dispatch('estadoActualizacion', title: "Registrado", icon: 'success', message: $message);
        } else {
            $message = "El producto NO se ha registrado correctamente.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
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
            'comision' => 'required',
            'codigo_producto' => ['required', Rule::unique('productos')],
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'tipo_producto' => 'required',
            'precio_unitario_con_iva' => 'required',
            'precio_unitario_sin_iva' => 'required',
            'costo_unitario' => 'required',
            'estado' => 'required'
        ], [
            'categoria.required' => 'La categoría es requerida',
            'tipo.required' => 'El tipo de impuesto es requerido',
            'comision.required' => 'La comisión es requerida',
            'codigo_producto.required' => 'El código del producto es requerido',
            'codigo_producto.unique' => 'El código del producto ya existe',
            'descripcion.required' => 'La descripción es requerida',
            'unidad_medida.required' => 'La unidad de medida es requerida',
            'tipo_producto.required' => 'El tipo de producto es requerido',
            'precio_unitario_con_iva.required' => 'El precio con IVA es requerido',
            'precio_unitario_sin_iva.required' => 'El precio sin IVA es requerido',
            'costo_unitario.required' => 'El costo unitario es requerido',
            'estado.required' => 'El estado es requerido'
        ]);
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-productos');
    }

    public function cancelarRegistrarProducto()
    {
        return redirect()->route('admin-productos');
    }
}
