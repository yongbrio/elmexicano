<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\HistorialTransferenciasModel;
use App\Models\SucursalesModel;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaTransferenciasInventarioTable extends LivewireTable
{
    protected string $model = HistorialTransferenciasModel::class;


    protected function columns(): array
    {
        return [
            Column::make(__('Producto'), function ($value) {
                return $value->codigo_producto . " - " . $value->nombre_producto;
            })->sortable()->searchable(),

            Column::make(__('Sucursal Origen'), 'nombre_sucursal_origen')->sortable()->searchable(),

            Column::make(__('Cantidad transferida'), 'cantidad_transferida')->sortable()->searchable(),

            Column::make(__('Sucursal Destino'), 'nombre_sucursal_destino')->sortable()->searchable(),

            Column::make(__('Registrado por'), function ($value) {
                $usuario = User::find($value->registrado_por);
                return $usuario->name . " " . $usuario->apellidos;
            })->sortable()->searchable(),

            Column::make(__('Fecha de registro'), 'created_at')->sortable()->searchable(),


        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }


    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }
}
