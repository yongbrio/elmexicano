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
    public $comisiona;
    public $estado;
    public $tipoSeleccionado;
    public $sucursal;
    public $sucursal_actual;
    public $comision;
    public $tipo_producto;
    #[Validate('image')]
    public $imagen;
    public $imagen_db;
    public $listaProductos;

    public function mount($id)
    {
        $this->id = $id;

        $inventario = InventarioModel::find($this->id);

        if ($inventario) {

            $this->sucursal = $inventario->sucursal?->id;
            $this->codigo_producto = $inventario->producto?->codigo_producto;
            $this->categoria = $inventario->producto?->categorias?->id;
            $this->tipo_producto = $inventario->producto?->tipoProducto?->id;
            $this->descripcion = $inventario->producto?->descripcion;
            $this->tipo = $inventario->producto?->tipoImpuesto?->id;
            $this->impuesto = $inventario->producto?->tipoImpuesto?->impuesto;
            $this->unidad_medida = $inventario->producto?->unidadMedida?->id;
            $this->costo_unitario = $inventario->producto?->costo_unitario;
            $this->precio_unitario_con_iva = $inventario->producto?->precio_unitario_con_iva;
            $this->precio_unitario_sin_iva = $inventario->producto?->precio_unitario_sin_iva;
            $this->imagen_db = $inventario->producto?->imagen;

            $this->stock_minimo = $inventario->stock_minimo;
            $this->stock = $inventario->stock;
            $this->comisiona = $inventario->comisiona;
            $this->estado = $inventario->estado;

            $this->comision = $inventario->producto?->comision;
            $this->sucursal_actual = $inventario->sucursal;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.inventario.editar-inventario');
    }

    public function actualizarInventario()
    {
        $this->validacionCampos();

        $inventario = InventarioModel::find($this->id);

        if ($inventario) {

            $inventario->stock = $this->stock;
            $inventario->stock_minimo = $this->stock_minimo;
            $inventario->registrado_por = Auth::user()->id;
            $inventario->comisiona = $this->comisiona;
            $inventario->estado = $this->estado;

            $actualizarInventario = $inventario->save();

            if ($actualizarInventario) {
                $message = "El producto se ha actualizado correctamente en el inventario.";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
                $message = "El producto NO se ha actualizado correctamente en el inventario.";
                $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'stock' => 'required',
            'stock_minimo' => 'required',
            'comisiona' => 'required',
            'estado' => 'required'
        ], [
            'stock.required' => 'El stock es requerido',
            'stock_minimo.required' => 'El stock mínimo es requerido',
            'comisiona.required' => 'Comisiona es requerida',
            'estado.required' => 'El estado es requerido',
        ]);
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
