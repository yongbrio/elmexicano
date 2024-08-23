<?php

namespace App\Livewire\Administracion\Log;

use App\Models\LogModel;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaLogTable extends LivewireTable
{
    protected string $model = LogModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Id Registro'), 'id')->sortable()->searchable(),
            Column::make(__('Id Usuario'), 'id_usuario')->sortable()->searchable(),
            Column::make(__('Nombre Usuario'), 'nombre_usuario')->sortable()->searchable(),
            Column::make(__('Nombre Completo'), 'nombre_apellido')->sortable()->searchable(),
            Column::make(__('Acción'), 'action')->sortable()->searchable(),
            Column::make(__('Modulo'), function ($value) {
                return $this->ModeloModulo($value->model);
            })->sortable()->searchable(),
            Column::make(__('Cambios/Registros'), function (mixed $value): string {
                return '<button type="button" wire:click="verLog(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-eye"></i></button>';
            })->asHtml(),
            Column::make(__('Fecha Registro'), 'created_at')->sortable()->searchable(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }
    
    function ModeloModulo($model)
    {
        // Separar la cadena en función de la barra invertida
        $parts = explode('\\', $model);

        // Obtener el último elemento de la cadena, que debería ser el nombre del modelo
        $modelName = end($parts);

        switch ($modelName) {
            case 'ClientesModel':
                return 'Clientes';

            case 'CategoriasModel':
                return 'Categorías';

            case 'CuentasBancariasModel':
                return 'Cuentas Bancarias';

            case 'DepartamentosModel':
                return 'Departamentos';

            case 'EgresosModel':
                return 'Egresos';

            case 'EmpresasModel':
                return 'Empresas';

            case 'HistorialTransferenciasModel':
                return 'Historial de Transferencias';

            case 'InventarioModel':
                return 'Inventario';

            case 'MunicipiosModel':
                return 'Municipios';

            case 'OrdenesModel':
                return 'Órdenes';

            case 'PerfilesModel':
                return 'Perfiles';

            case 'ProveedoresModel':
                return 'Proveedores';

            case 'SucursalesModel':
                return 'Sucursales';

            case 'TipoAfectacionImpuestoModel':
                return 'Tipo de Afectación de Impuesto';

            case 'TipoProductoModel':
                return 'Tipo de Producto';

            case 'UnidadesMedidaModel':
                return 'Unidades de Medida';

            case 'User':
                return 'Usuarios';

            default:
                return 'Módulo desconocido';
        }
    }

    function verLog($id){
        $this->dispatch('verLog', id: $id);
    }
}
