<?php

namespace App\Livewire\General\Caja;

use App\Models\OrdenesModel;
use App\Models\SucursalesModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use RamonRietdijk\LivewireTables\Columns\Column;

class ListaOrdenes extends LivewireTable
{
    protected string $model = OrdenesModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Orden'), 'id')->sortable()->searchable(),
            Column::make(__('Fecha'), 'updated_at')->sortable()->searchable(),
            Column::make(__('Tipo'), function ($value) {
                return strtoupper($value->tipo_orden);
            })->sortable()->searchable(),
            Column::make(__('Sucursal'),  function ($value) {
                $sucursal = SucursalesModel::find($value->id_sucursal);
                return  strtoupper($sucursal->nombre_sucursal);
            })->searchable(),
            Column::make(__('ID'),  function ($value) {
                $datos = json_decode($value->datos);
                return  $datos->telefono;
            })->searchable(),
            Column::make(__('Grupo'),  function ($value) {
                $datos = json_decode($value->datos);
                return  strtoupper($datos->grupo);
            })->searchable(),
            Column::make(__('Detalle'),  function ($value) {
                return  strtoupper(json_decode($value->comentarios));
            })->searchable(),
            Column::make(__('Usuario'),  function ($value) {
                $usuario = User::find($value->registrado_por);
                return  strtoupper($usuario->name . " " . $usuario->apellidos);
            })->searchable(),
            Column::make(__('Total'),  function ($value) {
                $detalle = json_decode($value->detalle);
                $suma = 0;
                if (!empty($detalle)) {
                    foreach ($detalle as $prod) {
                        $suma += $prod->total;
                    }
                }
                return  "$ ".number_format($suma, 2, '.', ',');
            })->searchable(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }
}
