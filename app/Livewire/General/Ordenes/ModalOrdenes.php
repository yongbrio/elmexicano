<?php

namespace App\Livewire\General\Ordenes;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use App\Models\InventarioModel;
use App\Models\OrdenesModel;
use App\Models\ProveedoresModel;
use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ModalOrdenes extends Component
{
    public $nombre_sucursal;
    public $es_corporativo;
    public $paso1 = true;
    public $paso2;
    public $paso3;
    public $paso4;
    public $paso5;

    public $sucursal;
    public $tipo_orden;
    public $id_cliente;
    public $id_proveedor;
    public $id_empresa;
    public $listaClientes;
    public $listaProveedores;
    public $listaProductos;
    public $buscar_cliente;
    public $buscar_proveedor;
    public $producto_buscar;
    public $id_producto;
    public $stock_disponible_origen;
    public $stock_transferencia;
    public $precio_unitario_con_iva;

    public $codigo_producto;
    public $producto_nombre;
    public $listaProductosAgregados = [];

    public function mount()
    {
        $sucursalId = Auth::user()->caja;
        $nombre_sucursal = SucursalesModel::find($sucursalId);
        $this->nombre_sucursal = $nombre_sucursal->nombre_sucursal;
        if (strtolower(trim($this->nombre_sucursal)) == 'corporativo') {
            $this->es_corporativo = true;
        } else {
            $this->es_corporativo = false;
            $this->sucursal = Auth::user()->caja;
            $this->cambiar(2);
        }
    }

    public function render()
    {
        return view('livewire.general.ordenes.modal-ordenes');
    }

    public function validacionSucursal()
    {
        return  $this->validate([
            'sucursal' => 'required'
        ], [
            'sucursal.required' => 'La sucursal es requerida'
        ]);
    }

    public function validacionTipoOrden()
    {
        return  $this->validate([
            'tipo_orden' => 'required'
        ], [
            'tipo_orden.required' => 'El tipo de orden es requerido'
        ]);
    }

    public function validacionCliente()
    {
        return  $this->validate([
            'id_cliente' => 'required'
        ], [
            'id_cliente.required' => 'El cliente es requerido'
        ]);
    }

    public function validacionProveedor()
    {
        return  $this->validate([
            'id_proveedor' => 'required'
        ], [
            'id_proveedor.required' => 'El proveedor es requerido'
        ]);
    }

    public function validacionEmpresa()
    {
        return  $this->validate([
            'id_empresa' => 'required'
        ], [
            'id_empresa.required' => 'La empresa es requerida'
        ]);
    }

    public function validarSucursal()
    {
        if ($this->tipo_orden == 'ingreso') {
            $clientes = ClientesModel::where('sucursal', $this->sucursal)->count();
            if ($clientes == 0) {
                $message = "La sucursal seleccionada no tiene clientes asociados";
                $this->dispatch('alertas', title: "Error", icon: 'error', message: $message);
                return false;
            }
            return true;
        } else if ($this->tipo_orden == 'egreso') {
            $proveedores = ProveedoresModel::where('sucursal', $this->sucursal)->count();
            if ($proveedores == 0) {
                $message = "La sucursal seleccionada no tiene proveedores asociados";
                $this->dispatch('alertas', title: "Error", icon: 'error', message: $message);
                return false;
            }
            return true;
        }
    }

    public function cambiar($paso)
    {
        if ($paso == 1) {
            $this->sucursal = null;
            $this->tipo_orden = null;
            $this->paso1 = true;
            $this->paso2 = null;
            $this->paso3 = null;
            $this->paso4 = null;
            $this->paso5 = null;
        }

        if ($paso == 2) {
            $this->validacionSucursal();
            $this->reiniciarDatos();
            $this->paso1 = 'disabled';
            $this->paso2 = true;
            $this->paso3 = null;
            $this->paso4 = null;
            $this->paso5 = null;
        }

        if ($paso == 3) {
            $this->buscar_proveedor = null;
            $this->id_proveedor = null;
            $this->buscar_cliente = null;
            $this->id_cliente = null;
            $this->validacionTipoOrden();
            $this->paso1 = 'disabled';
            $this->paso2 = 'disabled';
            $this->paso3 = true;
            $this->paso4 = null;
            $this->paso5 = null;
        }

        if ($paso == 4) {
            if ($this->tipo_orden == 'ingreso') {
                $this->validacionCliente();
            } else if ($this->tipo_orden == 'egreso') {
                $this->validacionProveedor();
            }

            $this->paso1 = 'disabled';
            $this->paso2 = 'disabled';
            $this->paso3 = 'disabled';
            $this->paso4 = true;
            $this->paso5 = null;
        }

        if ($paso == 5) {

            $this->validacionEmpresa();

            $this->paso1 = 'disabled';
            $this->paso2 = 'disabled';
            $this->paso3 = 'disabled';
            $this->paso4 = 'disabled';
            $this->paso5 = true;
            $this->registrarOrden();
        }
    }

    public function buscarCliente()
    {
        if (!empty(trim($this->buscar_cliente))) {

            $this->listaClientes = ClientesModel::where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('nombre_legal', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('nit', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('telefono', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('grupo', 'like', '%' . $this->buscar_cliente . '%');
            })
                ->where('estado', 1)
                ->orderBy('nombre_legal')
                ->take(5)
                ->get();

            $this->id_cliente = null;
            $this->id_empresa = null;
        } else {
            $this->listaClientes = null;
            $this->id_cliente = null;
            $this->id_empresa = null;
        }
    }

    public function setearNombreCliente($id)
    {

        $this->listaClientes = null;

        $cliente = ClientesModel::find($id);

        if ($cliente) {
            $this->buscar_cliente = $cliente->nombre_legal;
            $this->id_cliente = $cliente->id;
            $this->id_empresa = $cliente->empresa_factura;
            $this->cambiar(4);
        }
    }

    public function buscarProveedor()
    {
        if (!empty(trim($this->buscar_proveedor))) {

            $this->listaProveedores = ProveedoresModel::where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('nombre_legal', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('nit', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('telefono', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('grupo', 'like', '%' . $this->buscar_proveedor . '%');
            })
                ->where('estado', 1)
                ->orderBy('nombre_legal')
                ->take(5)
                ->get();

            $this->id_proveedor = null;
        } else {
            $this->listaProveedores = null;
            $this->id_proveedor = null;
        }
    }

    public function setearNombreProveedor($id)
    {

        $this->listaProveedores = null;

        $proveedor = ProveedoresModel::find($id);

        if ($proveedor) {

            $this->buscar_proveedor = $proveedor->nombre_legal;
            $this->id_proveedor = $proveedor->id;
            $this->cambiar(4);
        }
    }

    public function asignarEmpresaProveedor()
    {
        if ($this->id_empresa) {
        }
    }

    public function reiniciarDatos()
    {
        $this->id_cliente = null;
        $this->tipo_orden = null;
        $this->id_proveedor = null;
        $this->id_empresa = null;
        $this->listaClientes = null;
        $this->listaProveedores = null;
        $this->buscar_cliente = null;
        $this->buscar_proveedor = null;
    }

    public function registrarOrden()
    {
        $id_datos = 0;

        $datos = "";

        if ($this->tipo_orden == 'ingreso') {
            $id_datos = $this->id_cliente;
            $datos = ClientesModel::find($id_datos);
        } else if ($this->tipo_orden == 'egreso') {
            $id_datos = $this->id_proveedor;
            $datos = ProveedoresModel::find($id_datos);
        }

        $datos_empresa = EmpresasModel::find($this->id_empresa);

        $orden = OrdenesModel::create([
            'id_sucursal' => $this->sucursal,
            'id_datos' => $id_datos,
            'datos' => $datos,
            'tipo_orden' => $this->tipo_orden,
            'datos_empresa' => $datos_empresa,
            'status1' => '',
            'status2' => '',
            'registrado_por' => Auth::user()->id,
        ]);

        if ($orden && $this->tipo_orden == 'ingreso') {
            return redirect()->route('ordenes-ingreso', ['id' => $orden->id]);
        } else if ($orden && $this->tipo_orden == 'egreso') {
            return redirect()->route('ordenes-egreso', ['id' => $orden->id]);
        }
    }
}
