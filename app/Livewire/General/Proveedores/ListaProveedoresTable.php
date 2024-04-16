<?php

namespace App\Livewire\General\Proveedores;

use App\Models\ProveedoresModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaProveedoresTable extends LivewireTable
{
    protected string $model = ProveedoresModel::class;

    #[Locked]
    public int $estado;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        return $this->model()->query()->where('estado', '=', 1);
    }


    protected function columns(): array
    {
        return [
            Column::make(__('Teléfono'), 'telefono')->sortable()->searchable(),
            Column::make(__('Grupo'), 'grupo')->sortable()->searchable(),
            Column::make(__('Nombre Comercial'), 'nombre_comercial')->sortable()->searchable(),
            Column::make(__('Nombre Legal'), 'nombre_legal')->sortable()->searchable(),
            Column::make(__('NIT'), 'nit')->sortable()->searchable(),
            Column::make(__('Sucursal'), 'sucursal')->sortable()->searchable(),
            Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
            Column::make(__('Ciudad'), 'ciudad')->sortable()->searchable(),
            Column::make(__('Departamento'), 'departamento')->sortable()->searchable(),
            Column::make(__('Correo'), 'correo')->sortable()->searchable(),
            Column::make(__('Nombre encargado'), 'nombre_encargado')->sortable()->searchable(),
            Column::make(__('Descripción'), 'descripcion')->sortable()->searchable(),
            Column::make(__('Estado'), function (mixed $value): string {

                $estado = "";

                if ($value->estado == 1) {
                    $estado = "Activo";
                } else {
                    $estado = "Inactivo";
                }

                return $estado;
            }),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

}
