<?php

namespace App\Livewire\General\Ordenes;

use App\Models\EgresosModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use RamonRietdijk\LivewireTables\Columns\Column;

class ListaEgresos extends LivewireTable
{
    protected string $model = EgresosModel::class;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        return $this->model()->query()->with(['categoria1', 'categoria2', 'codigoProducto']);
    }

    protected function columns(): array
    {
        return [
            Column::make(__('Agregar'), function ($value): string {
                return '<button type="button"  wire:click="agregar(' . $value->id . ')" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 ">
                    <i class="fa-solid fa-plus"></i>
                </button>';
            })->asHtml(),
            Column::make(__('Código'), 'id')->sortable()->searchable(),
            Column::make(__('Categoría 1'), 'categoria1.nombre_categoria')->sortable()->searchable(),
            Column::make(__('Categoría 2'), 'categoria2.nombre_categoria')->sortable()->searchable(),
            Column::make(__('Descripción'), 'descripcion_egreso')->sortable()->searchable(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

    public function agregar($id)
    {
        $this->dispatch('agregar', id: $id);
    }

    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }
}
