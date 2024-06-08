<?php

namespace App\Livewire\General\Egresos;

use App\Models\EgresosModel;
use App\Models\UnidadesMedidaModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaEgresosTable extends LivewireTable
{
    protected string $model = EgresosModel::class;

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

            Column::make(__('Código de egreso'), 'codigo_egreso')->sortable()->searchable(),
            Column::make(__('Categoría 1'), 'categoria_1')->sortable()->searchable(),
            Column::make(__('Categoría 2'), 'categoria_2')->sortable()->searchable(),
            Column::make(__('Tipo de egreso'), function (mixed $value) {

                $tipo_egreso = "";

                if ($value->tipo_egreso == '1') {
                    $tipo_egreso = 'Insumo';
                } else if ($value->tipo_egreso == '2') {
                    $tipo_egreso = 'Regular';
                }

                return $tipo_egreso;
            })->sortable()->searchable(),
            Column::make(__('Descripción de Egreso'), 'descripcion_egreso')->sortable()->searchable(),
            Column::make(__('Código de producto'), 'codigo_producto')->sortable()->searchable(),
            Column::make(__('Unidad de medida'), function (mixed $value) {
                $unidad_medida = UnidadesMedidaModel::find($value->unidad_medida);
                return $unidad_medida->nombre_unidad_medida;
            })->sortable()->searchable(),
            Column::make(__('Estado'), function (mixed $value, EgresosModel $model): string {

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
