<?php

namespace App\Livewire\General\Ordenes;

use App\Models\InventarioModel;
use App\Models\OrdenesModel;
use App\Models\SucursalesModel;
use DateTime;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Ingreso extends Component
{
    public $id;

    public $orden;

    public $numero_orden;

    public $producto;

    public $precio_unitario_con_iva;

    public $stock_disponible;

    public $datos;

    public $fecha;

    public $nombre_sucursal;

    public $stock_transferencia;

    public $comision;

    public $listaProductosAgregados = [];

    public $comentario;

    public function mount(int $id)
    {
        $this->id = $id;

        $orden = OrdenesModel::where('id', $this->id)->where('tipo_orden', 'ingreso')->first();

        if ($orden) {

            $this->orden = $orden;

            $this->datos = json_decode($this->orden->datos);

            $this->comentario = $this->orden->comentarios;

            $date = new DateTime($this->datos->created_at);

            $formattedDate = $date->format('Y-m-d');

            $this->fecha = $formattedDate;

            $sucursal = SucursalesModel::find($this->orden->id_sucursal);

            $this->nombre_sucursal = $sucursal->nombre_sucursal;

            // Verifica si $this->orden->detalle no está vacío y es una cadena
            if (!empty($this->orden->detalle) && is_string($this->orden->detalle)) {
                $decodedData = json_decode($this->orden->detalle, true);

                // Verifica si json_decode no produjo un error y devolvió un array válido
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedData)) {
                    $this->listaProductosAgregados = $decodedData;
                } else {
                    // Inicializa la variable en vacío si hay un error en la decodificación JSON
                    $this->listaProductosAgregados = [];
                }
            } else {
                // Inicializa la variable en vacío si los datos no son válidos o están vacíos
                $this->listaProductosAgregados = [];
            }
        } else {
            // La orden no existe, lanza una excepción o redirige a otra página
            abort(404, 'Orden no encontrada');
        }
    }

    public function registrarComentario()
    {
        $this->orden->comentarios = $this->comentario;

        if ($this->orden->save()) {
            $message = 'Comentario registrado';
            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        } else {
            $message = 'Error al registrar el comentario';
            $icon = 'error';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        }
    }

    public function validarStock()
    {
        // Remover espacios al inicio y al final
        $this->stock_transferencia = trim($this->stock_transferencia);

        // Verificar si el valor es un entero válido
        if (!ctype_digit($this->stock_transferencia)) {
            $message = "Ingrese un valor válido";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        // Convertir el valor a un entero
        /* $this->stock_transferencia = (int) $this->stock_transferencia; */

        // Verificar si el valor es mayor que el stock disponible
        if ($this->stock_transferencia > $this->stock_disponible) {
            $message = "La cantidad a agregar no puede ser mayor al disponible";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        // Verificar si el valor es menor o igual a cero
        if ($this->stock_transferencia <= 0) {
            $message = "El valor no puede ser cero o negativo";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        return true;
    }

    #[On('agregar')]
    public function agregar($id)
    {
        $this->producto = null;
        $this->precio_unitario_con_iva = null;
        $this->stock_disponible = null;
        $this->comision = null;
        $this->stock_transferencia = null;

        $producto = InventarioModel::find($id);

        if ($producto) {

            $this->producto = $producto;
            $this->precio_unitario_con_iva = $producto->precio_unitario_con_iva;
            $this->stock_disponible = $producto->stock;
            $this->comision = $producto->comision;
        }
    }

    public function agregarListaProductos()
    {
        if ($this->validarStock()) {

            $nuevoProducto = [
                'id_producto' => $this->producto->id,
                'id_sucursal' => $this->producto->sucursal,
                'codigo_producto' => $this->producto->codigo_producto,
                'cantidad_producto' => $this->stock_transferencia,
                'precio_unitario_con_iva' => $this->producto->precio_unitario_con_iva,
                'descripcion' => $this->producto->descripcion,
                'total' => $this->stock_transferencia * $this->producto->precio_unitario_con_iva,
            ];

            $existe = false;

            // Iterar sobre la lista de productos agregados
            foreach ($this->listaProductosAgregados as &$producto) {
                if ($producto['id_producto'] === $nuevoProducto['id_producto']) {
                    if (($nuevoProducto['cantidad_producto']) > $this->stock_disponible) {
                        $message = "La cantidad total ingresada supera la cantidad disponible en stock";
                        $elementId = 'stock_transferencia';
                        $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                        $this->stock_transferencia = null;
                        return; // Detener la ejecución del método
                    } else {
                        // Producto ya existe, actualizar cantidad y total
                        $producto['cantidad_producto'] += $nuevoProducto['cantidad_producto'];
                        $producto['total'] = $producto['cantidad_producto'] * $producto['precio_unitario_con_iva'];

                        $this->producto->stock = ($this->producto->stock - $nuevoProducto['cantidad_producto']);
                        $this->producto->save();

                        /* $this->orden->detalle = json_encode($this->listaProductosAgregados); */
                        $detalle = json_decode(json_encode($this->listaProductosAgregados));

                        foreach ($detalle as $key => $val) {
                            if ($val->id_producto === $producto['id_producto']) {
                                $val->cantidad_producto = $producto['cantidad_producto'];
                                $val->total = $producto['total'];
                            }
                        }

                        $this->orden->detalle = json_encode($detalle);

                        $this->orden->save();

                        $this->agregar($this->producto->id);

                        $existe = true;
                        $message = 'El producto se agregó a la lista';
                        $icon = 'success';
                        $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
                        $this->dispatch('recargarComponente');
                        break;
                    }
                }
            }

            // Si no se encontró el producto, agregarlo a la lista
            if (!$existe) {

                $this->producto->stock = ($this->producto->stock - $nuevoProducto['cantidad_producto']);
                $this->producto->save();
                $this->agregar($this->producto->id);

                $message = 'El producto se agregó a la lista';
                $icon = 'success';
                $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
                $this->dispatch('recargarComponente');
                $this->listaProductosAgregados[] = $nuevoProducto;
                $this->orden->detalle = json_encode($this->listaProductosAgregados);
                $this->orden->save();
            }
        }
    }

    public function modificarCantidadProducto(&$productos, $id_producto, $nueva_cantidad)
    {
        foreach ($productos as &$producto) {
            if ($producto['id_producto'] == $id_producto) {
                $producto['cantidad_producto'] = $nueva_cantidad;
                return true; // Producto encontrado y cantidad modificada
            }
        }
        return false; // Producto no encontrado
    }

    public function eliminarProductoLista($id)
    {    // Encuentra el producto que se va a eliminar para obtener su cantidad
        $cantidadProducto = 0;
        $this->listaProductosAgregados = array_filter($this->listaProductosAgregados, function ($producto) use ($id, &$cantidadProducto) {
            if ($producto['id_producto'] === $id) {
                $cantidadProducto = $producto['cantidad_producto']; // Obtén la cantidad del producto
                return false; // Elimina el producto del array
            }
            return true; // Mantén el producto en el array
        });

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaProductosAgregados));
        $this->orden->save();

        // Actualiza la tabla con la cantidad del producto eliminado
        $this->actualizarInventario($id, $cantidadProducto);
    }

    private function actualizarInventario($id, $cantidadProducto)
    {
        $inventario = InventarioModel::find($id);

        if ($inventario) {

            $inventario->stock = $inventario->stock + $cantidadProducto;
            $inventario->save();
            $this->dispatch('recargarComponente');
            $message = 'El producto se eliminó de la lista';
            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        }
    }

    public function render()
    {
        return view('livewire.general.ordenes.ingreso');
    }
}
