<?php

namespace App\Livewire\Administracion\Inventario;

use App\Exports\HistorialTransferenciaInventarioExport;
use App\Models\HistorialTransferenciasModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class TransferenciaInventario extends Component
{
    public $listaProductos;
    public $sucursal_origen;
    public $sucursal_destino;
    public $producto_origen;
    public $producto_origen_nombre;
    public $id_producto_origen;
    public $stock_disponible_origen;
    public $stock_transferencia;
    public $listaTransferencias = [];
    public $codigo_producto;
    public $start_date;
    public $end_date;


    public function render()
    {
        return view('livewire.administracion.inventario.transferencia-inventario');
    }

    public function buscarProductoOrigen()
    {
        if (!empty(trim($this->producto_origen)) && trim($this->sucursal_origen != '')) {

            $this->listaProductos = InventarioModel::where(function ($query) {
                $query->where('descripcion', 'like', '%' . $this->producto_origen . '%')
                    ->orWhere('codigo_producto', 'like', '%' . $this->producto_origen . '%');
            })
                ->where('sucursal', $this->sucursal_origen)
                ->where('estado', 1)
                ->orderBy('codigo_producto')
                ->take(5)
                ->get();


            $this->id_producto_origen = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
        } else if (!empty(trim($this->producto_origen)) && trim($this->sucursal_origen == '')) {

            $message = "Seleccione primero una sucursal de origen";
            $elementId = 'producto_origen';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->listaProductos = null;
            $this->id_producto_origen = null;
            $this->codigo_producto = null;
            $this->producto_origen = null;
            $this->producto_origen_nombre = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
        } else {

            $this->listaProductos = null;
            $this->id_producto_origen = null;
            $this->codigo_producto = null;
            $this->producto_origen = null;
            $this->producto_origen_nombre = null;
            $this->stock_disponible_origen = null;
            $this->stock_transferencia = null;
        }
    }

    public function setearNombreProducto($id)
    {
        $this->listaProductos = null;

        $nombreProducto = InventarioModel::find($id);

        if ($nombreProducto) {

            if ($nombreProducto->stock != 0) {
                $this->producto_origen = $nombreProducto->codigo_producto . " - " . $nombreProducto->descripcion  . " - " . $nombreProducto->stock;
                $this->producto_origen_nombre = $nombreProducto->descripcion;
                $this->id_producto_origen = $id;
                $this->codigo_producto = $nombreProducto->codigo_producto;
                $this->stock_disponible_origen = $nombreProducto->stock;
            } else {

                $message = "El prodcuto está sin stock disponible";
                $elementId = 'stock_transferencia';
                $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            }
        }
    }

    public function cambiarSucursal()
    {
        $this->listaProductos = null;
        $this->id_producto_origen = null;
        $this->codigo_producto = null;
        $this->producto_origen = null;
        $this->producto_origen_nombre = null;
        $this->stock_disponible_origen = null;
        $this->stock_transferencia = null;
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'sucursal_origen' => 'required',
            'id_producto_origen' => 'required',
            'stock_transferencia' => 'required|integer',
            'sucursal_destino' => 'required',
        ], [
            'sucursal_origen.required' => 'La sucursal de origen es requerida',
            'id_producto_origen.required' => 'El producto es requerido',
            'stock_transferencia.required' => 'El Stock a transferir es obligatorio',
            'stock_transferencia.integer' => 'El Stock debe ser númerico',
            'sucursal_destino.required' => 'La sucursal de destino es requerida',
        ]);
    }

    public function agregarTransferenciaInventario()
    {
        $this->validacionCampos();

        $validarProducto = InventarioModel::where('codigo_producto', $this->codigo_producto)->where('sucursal', $this->sucursal_destino)->exists();

        $origen = $this->sucursal_origen;
        $producto = $this->codigo_producto;
        $destino = $this->sucursal_destino;

        // Filtra las transferencias existentes para encontrar coincidencias, excluyendo el índice actual
        $exists = array_filter($this->listaTransferencias, function ($existingTransferencia) use ($origen, $producto, $destino) {
            return
                $existingTransferencia['id_sucursal_origen'] === $origen &&
                $existingTransferencia['codigo_producto_origen'] === $producto &&
                $existingTransferencia['id_sucursal_destino'] === $destino;
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($exists)) {
            if ($validarProducto) {

                if ($this->stock_transferencia > $this->stock_disponible_origen) {
                    $message = "El stock a transferir no puede ser mayor al disponible";
                    $elementId = 'stock_transferencia';
                    $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                    $this->stock_transferencia = null;
                } else {

                    $sucursal_nombre_origen = SucursalesModel::where('id', $this->sucursal_origen)->first();
                    $sucursal_nombre_destino = SucursalesModel::where('id', $this->sucursal_destino)->first();

                    $this->listaTransferencias[] = [
                        'id_producto_origen' => $this->id_producto_origen,
                        'codigo_producto_origen' => $this->codigo_producto,
                        'id_sucursal_origen' => $this->sucursal_origen,
                        'origen' => $sucursal_nombre_origen->nombre_sucursal,
                        'producto' => $this->producto_origen,
                        'producto_nombre' => $this->producto_origen_nombre,
                        'stock_origen' => $this->stock_disponible_origen,
                        'cantidad' => $this->stock_transferencia,
                        'id_sucursal_destino' => $this->sucursal_destino,
                        'destino' => $sucursal_nombre_destino->nombre_sucursal
                    ];

                    $this->listaProductos = null;
                    $this->sucursal_origen = null;
                    $this->sucursal_destino = null;
                    $this->producto_origen = null;
                    $this->producto_origen_nombre = null;
                    $this->id_producto_origen = null;
                    $this->codigo_producto = null;
                    $this->stock_disponible_origen = null;
                    $this->stock_transferencia = null;

                    $message = "¡Se ha agregado la transferencia!";
                    $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
                }
            } else {

                $message = "El producto no existe en la sucursal destino";
                $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
            }
        } else {
            $message = "Ya se encuentra una transferencia similar en estado pendiente para ser aprobada";
            $this->dispatch('estadoActualizacion', title: "¡Error!", icon: 'error', message: $message);
        }
    }

    public function eliminarTransferencia($id)
    {
        unset($this->listaTransferencias[$id]);
    }

    public function crearTransferencia($id)
    {
        //Array con la información a transferir
        $transferencia = $this->listaTransferencias[$id];

        //Actualización del producto de la sucursal origen
        $nuevoStock = $transferencia['stock_origen'] - $transferencia['cantidad'];
        $producto_origen = InventarioModel::find($transferencia['id_producto_origen']);
        $producto_origen->stock = $nuevoStock;
        $estado_origen = $producto_origen->save();

        //Actualización del producto de la sucursal destino
        /*         $producto_destino = InventarioModel::where('codigo_producto', $transferencia['codigo_producto_origen'])->where('sucursal', $transferencia['id_sucursal_destino'])->first();
        $nuevoStock = $producto_destino->stock + $transferencia['cantidad'];
        $producto_destino->stock = $nuevoStock;
        $estado_destino = $producto_destino->save(); */

        if ($estado_origen) {

            //Se registra la transferencia en el historial
            $historial = HistorialTransferenciasModel::create([
                'id_sucursal_origen' => $transferencia['id_sucursal_origen'],
                'nombre_sucursal_origen' =>  $transferencia['origen'],
                'nombre_producto' =>  $transferencia['producto_nombre'],
                'codigo_producto' => $transferencia['codigo_producto_origen'],
                'cantidad_transferida' => $transferencia['cantidad'],
                'transferencia_recibida' => 0,
                'id_sucursal_destino' => $transferencia['id_sucursal_destino'],
                'nombre_sucursal_destino' => $transferencia['destino'],
                'registrado_por' => Auth::user()->id
            ]);

            if ($historial) {

                $this->listaProductos = null;
                $this->sucursal_origen = null;
                $this->sucursal_destino = null;
                $this->producto_origen = null;
                $this->producto_origen_nombre = null;
                $this->id_producto_origen = null;
                $this->codigo_producto = null;
                $this->stock_disponible_origen = null;
                $this->stock_transferencia = null;
                //Recargar la lista de inventario
                $this->dispatch('recargarComponente');
                $message = "El inventario se ha transferido";
                $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
                unset($this->listaTransferencias[$id]);
            }
        } else {
            $message = "Ocurrió un problema. vuelva a intentarlo";
            $this->dispatch('estadoActualizacion', title: "¡Error!", icon: 'error', message: $message);
        }
    }

    public function generarExcelHistorial()
    {
        // Validar que el usuario ingrese un rango de fechas válido
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
        ]);

        // Descargar el archivo Excel con los datos filtrados
        return Excel::download(new HistorialTransferenciaInventarioExport($this->start_date, $this->end_date), 'historial_tranferencias.xlsx');
    }
}
