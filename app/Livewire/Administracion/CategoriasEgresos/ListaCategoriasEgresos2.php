<?php

namespace App\Livewire\Administracion\CategoriasEgresos;

use App\Models\CategoriasEgresos2Model;
use App\View\Components\Select2;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaCategoriasEgresos2 extends LivewireTable
{
    protected string $model = CategoriasEgresos2Model::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="eliminarCategoriaAsociada2(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 me-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"><i class="fa-solid fa-trash-can"></i></button>';
            })->asHtml(),
            Column::make(__('Nombre de la categoría'), 'nombre_categoria')->sortable()->searchable(),
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

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $categoria = CategoriasEgresos2Model::find($id);
        $categoria->estado = $estado;
        $categoria->save();
        $this->dispatch('recargarComponenteListaCategoriasEgresos2');
    }

    #[On('recargarComponenteListaCategoriasEgresos2')]
    public function recargarComponenteListaCategoriasEgresos2()
    {
        $this->columns();
    }

    public function eliminarCategoriaAsociada2($id)
    {
        $this->dispatch('eliminarCategoriaAsociada2', id: $id);
    }
}
