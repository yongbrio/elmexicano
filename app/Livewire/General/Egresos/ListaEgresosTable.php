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
        return $this->model()->query()->where('egresos.estado', '=', 1);
    }

    protected function columns(): array
    {
        return [
            Column::make(__('Código de egreso'), 'id')->sortable()->searchable(),
            Column::make(__('Categoría 1'), 'categoria1.nombre_categoria')->sortable()->searchable(),
            Column::make(__('Categoría 2'), 'categoria2.nombre_categoria')->sortable()->searchable(),
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
            Column::make(__('Código y Nombre'), function (mixed $value) {
                return $value->codigoProducto ? $value->codigoProducto->codigo_producto . ' - ' . $value->codigoProducto->descripcion : "N/A";
            })->sortable()->searchable(),
            Column::make(__('Unidad de medida'), function (mixed $value) {
                if ($value->unidad_medida > 0) {
                    $unidad_medida = UnidadesMedidaModel::find($value->unidad_medida);
                    return $unidad_medida->nombre_unidad_medida;
                } else {
                    return "N/A";
                }
            })->sortable()->searchable(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }
}
