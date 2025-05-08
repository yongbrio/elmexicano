<?php

namespace App\Livewire\Administracion\CategoriasEgresos;

use App\Models\CategoriasEgresosAsociadasModel;
use Livewire\Attributes\On;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaCategoriasAsociadas extends LivewireTable
{
    protected string $model = CategoriasEgresosAsociadasModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="eliminarCategoria(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 me-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"><i class="fa-solid fa-trash-can"></i></button>';
            })->asHtml(),

            Column::make(__('Nombre categoría 1'), 'categoria1.nombre_categoria')
                ->qualifyUsingAlias()
                ->sortable()
                ->searchable(),

            Column::make(__('Nombre categoría 2'), 'categoria2.nombre_categoria')
                ->qualifyUsingAlias()
                ->sortable()
                ->searchable(),

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

    public function eliminarCategoria($id)
    {
        $this->dispatch('eliminarCategoria', id: $id);
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $categoria = CategoriasEgresosAsociadasModel::find($id);
        $categoria->estado = $estado;
        $categoria->save();
    }

    #[On('recargarComponenteListaCategoriasAsociadas')]
    public function recargarComponenteListaCategoriasAsociadas()
    {
        $this->columns();
    }
}
