<?php

namespace App\Livewire\Administracion\Ordenes;

use App\Models\ClientesModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RegistrarOrdenes extends Component
{
    public $habilitarProducto;
    public $habilitarCliente;
    public $habilitarInfoPago;
    public $habilitarResumen;

    public $listaProductos;
    public $listaClientes;
    public $producto_buscar;
    public $buscar_cliente;
    public $producto_nombre;
    public $id_producto;
    public $id_cliente;
    public $codigo_producto;
    public $sucursal_origen;
    public $stock_disponible_origen;
    public $stock_transferencia;
    public $precio_unitario_con_iva;

    public $valorTotalProductos;
    public $valorRestante;

    public $listaProductosAgregados = [];

    public $forma_pago;
    public $medio_pago;
    public $valorParcial;

    public function render()
    {
        return view('livewire.administracion.ordenes.registrar-ordenes');
    }

    public function mount()
    {
        $this->habilitarProducto = true;
        $this->habilitarCliente = false;
        $this->habilitarInfoPago = false;
        $this->habilitarResumen = false;
    }

    public function buscarProducto()
    {
        if (!empty(trim($this->producto_buscar)) && trim($this->sucursal_origen != '')) {

            $this->listaProductos = InventarioModel::where(function ($query) {
                $query->where('descripcion', 'like', '%' . $this->producto_buscar . '%')
                    ->orWhere('codigo_producto', 'like', '%' . $this->producto_buscar . '%');
            })
                ->where('sucursal', $this->sucursal_origen)
                ->where('estado', 1)
                ->orderBy('codigo_producto')
                ->take(5)
                ->get();

            $this->id_producto = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
            $this->precio_unitario_con_iva = null;
        } else if (!empty(trim($this->producto_buscar)) && trim($this->sucursal_origen == '')) {

            $message = "Seleccione primero una sucursal de origen";
            $elementId = 'producto_origen';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->listaProductos = null;
            $this->id_producto = null;
            $this->codigo_producto = null;
            $this->producto_buscar = null;
            $this->producto_nombre = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
            $this->precio_unitario_con_iva = null;
        } else {

            $this->listaProductos = null;
            $this->id_producto = null;
            $this->codigo_producto = null;
            $this->producto_buscar = null;
            $this->producto_nombre = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
            $this->precio_unitario_con_iva = null;
        }
    }

    public function setearNombreProducto($id)
    {
        $this->listaProductos = null;

        $nombreProducto = InventarioModel::find($id);

        if ($nombreProducto) {

            if ($nombreProducto->stock != 0) {
                $this->producto_buscar = $nombreProducto->codigo_producto . " - " . $nombreProducto->descripcion  . " - " . $nombreProducto->stock;
                $this->producto_nombre = $nombreProducto->descripcion;
                $this->id_producto = $id;
                $this->codigo_producto = $nombreProducto->codigo_producto;
                $this->stock_disponible_origen = $nombreProducto->stock;
                foreach ($this->listaProductosAgregados as &$producto) {
                    if ($producto['id_producto'] === $this->id_producto && $producto['id_sucursal'] === $this->sucursal_origen) {
                        $this->stock_disponible_origen = ($nombreProducto->stock) - ($producto['cantidad_producto']);
                        break;
                    }
                }

                $this->precio_unitario_con_iva = $nombreProducto->precio_unitario_con_iva;
            } else {

                $message = "El producto está sin stock disponible";
                $elementId = 'stock_transferencia';
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            }
        }
    }

    public function cambiarSucursal()
    {
        $this->listaProductos = null;
        $this->id_producto = null;
        $this->codigo_producto = null;
        $this->producto_buscar = null;
        $this->producto_nombre = null;
        $this->stock_disponible_origen = null;
        $this->stock_transferencia = null;
    }

    public function validarStock()
    {
        if (is_numeric($this->stock_transferencia) && is_int($this->stock_transferencia + 0)) {
            if ($this->stock_transferencia > $this->stock_disponible_origen) {
                $message = "La cantidad a agregar no puede ser mayor al disponible";
                $elementId = 'stock_transferencia';
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                $this->stock_transferencia = null;
            }
        }
    }

    public function agregarListaProductos()
    {
        $nombre_sucursal = SucursalesModel::find($this->sucursal_origen);

        $nuevoProducto = [
            'id_producto' => $this->id_producto,
            'id_sucursal' => $this->sucursal_origen,
            'nombre_sucursal' => $nombre_sucursal->nombre_sucursal,
            'producto_nombre' => $this->producto_nombre,
            'precio_unitario_con_iva' => $this->precio_unitario_con_iva,
            'cantidad_producto' => $this->stock_transferencia,
            'total' => $this->stock_transferencia * $this->precio_unitario_con_iva,
        ];

        $existe = false;

        // Iterar sobre la lista de productos agregados
        foreach ($this->listaProductosAgregados as &$producto) {
            if ($producto['id_producto'] === $nuevoProducto['id_producto'] && $producto['id_sucursal'] === $nuevoProducto['id_sucursal']) {
                if ((/* $producto['cantidad_producto'] +  */$nuevoProducto['cantidad_producto']) > $this->stock_disponible_origen) {
                    $message = "La cantidad total ingresada supera la cantidad disponible en stock => " . ($producto['cantidad_producto'] + $nuevoProducto['cantidad_producto']) . " => " . $this->stock_disponible_origen;
                    $elementId = 'stock_transferencia';
                    $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                    $this->stock_transferencia = null;
                    return; // Detener la ejecución del método
                } else {
                    // Producto ya existe, actualizar cantidad y total
                    $producto['cantidad_producto'] += $nuevoProducto['cantidad_producto'];
                    $producto['total'] = $producto['cantidad_producto'] * $producto['precio_unitario_con_iva'];
                    $existe = true;
                    $message = 'El producto se agregó a la lista';
                    $icon = 'success';
                    $this->dispatch('mensajes', message: $message, icon: $icon);
                    $this->cambiarSucursal();
                    break;
                }
            }
        }

        // Si no se encontró el producto, agregarlo a la lista
        if (!$existe) {
            $message = 'El producto se agregó a la lista';
            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon);
            $this->listaProductosAgregados[] = $nuevoProducto;
            $this->cambiarSucursal();
        }
    }

    public function eliminarProductoLista($id)
    {
        /*  $this->stock_disponible_origen = $this->stock_disponible_origen + $this->listaProductosAgregados[$id]['cantidad_producto']; */

        unset($this->listaProductosAgregados[$id]);

        if (!empty($this->listaProductosAgregados)) {
            $this->listaProductosAgregados = array_values($this->listaProductosAgregados); // Reindexar el array
        }

        $this->cambiarSucursal();
    }

    public function cambiar($paso)
    {
        if ($paso == 1) {
            $this->habilitarProducto = true;
            $this->habilitarCliente = false;
            $this->habilitarInfoPago = false;
            $this->habilitarResumen = false;
        }

        if ($paso == 2) {
            $this->habilitarCliente = true;
            $this->habilitarProducto = false;
            $this->habilitarInfoPago = false;
            $this->habilitarResumen = false;
        }

        if ($paso == 3) {
            $this->habilitarInfoPago = true;
            $this->habilitarCliente = false;
            $this->habilitarProducto = false;
            $this->habilitarResumen = false;
            $this->valorTotalProductos = $this->darTotalProductos();
        }
    }

    public function buscarCliente()
    {
        if (!empty(trim($this->buscar_cliente))) {

            $this->listaClientes = ClientesModel::where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('nombre_legal', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('nit', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('telefono', 'like', '%' . $this->buscar_cliente . '%');
            })
                /* ->where('sucursal', $this->sucursal_origen) */
                ->where('estado', 1)
                ->orderBy('nombre_legal')
                ->take(5)
                ->get();

            $this->id_cliente = null;
        } else {
            $this->listaClientes = null;
            $this->id_cliente = null;
        }
    }

    public function setearNombreCliente($id)
    {

        $this->listaClientes = null;

        $cliente = ClientesModel::find($id);

        if ($cliente) {
            $this->buscar_cliente = $cliente->nombre_legal;
            $this->id_cliente = $cliente->id;
        }
    }

    public function formaPago()
    {
        if ($this->forma_pago == 'pcont') {
            $this->valorParcial = null;
        }
    }

    public function medioPago()
    {

    }

    public function darTotalProductos()
    {
        $total = 0;
        foreach ($this->listaProductosAgregados as &$producto) {
            $total += $producto['total'];
        }

        return $total;
    }

    public function actualizarPagoTotal()
    {
        if (!empty(trim($this->valorParcial)) && !is_numeric(trim($this->valorParcial))) {
            $message = 'Ingrese un valor valido';
            $icon = 'error';
            $this->dispatch('mensajes', message: $message, icon: $icon);
            $this->valorParcial = null;
            $this->valorRestante = null;
            return;
        }

        if ($this->valorParcial > $this->darTotalProductos()) {

            $message = 'El valor parcial excede el valor total a pagar';
            $icon = 'warning';
            $this->dispatch('mensajes', message: $message, icon: $icon);
            $this->valorParcial = null;
            $this->valorRestante = null;
            return;
        } else if ($this->valorParcial == $this->darTotalProductos()) {

            $message = 'Si el valor parcial es igual al valor a pagar seleccione pago de contado';
            $icon = 'warning';
            $this->dispatch('mensajes', message: $message, icon: $icon);
            $this->valorParcial = null;
            $this->valorRestante = null;
            return;
        } else {
            $this->valorRestante = $this->darTotalProductos() - $this->valorParcial;
        }
    }
}
