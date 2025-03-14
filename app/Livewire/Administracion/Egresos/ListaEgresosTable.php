<?php

namespace App\Livewire\Administracion\Egresos;

use App\Models\EgresosModel;
use App\Models\UnidadesMedidaModel;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaEgresosTable extends LivewireTable
{

    protected string $model = EgresosModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value, EgresosModel $model): string {
                return '<button type="button" wire:click="editarEgreso(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
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
            Column::make(__('Estado'), function (mixed $value) {
                $activado = "";
                if ($value->estado == 1) {
                    $activado = "checked";
                }
                return view('livewire.acciones.activar-estado')->with([
                    'id' => $value->id,
                    'estado' => $value->estado,
                    'activado' => $activado
                ]);
            })->asHtml(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

    public function editarEgreso($id)
    {
        return redirect()->route('editar-egreso', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $egreso = EgresosModel::find($id);
        $egreso->estado = $estado;
        $egreso->save();
    }
}
