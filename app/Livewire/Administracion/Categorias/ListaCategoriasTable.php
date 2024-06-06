<?php

namespace App\Livewire\Administracion\Categorias;

use App\Models\CategoriasModel;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Livewire;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaCategoriasTable extends LivewireTable
{
    protected string $model = CategoriasModel::class;

    protected function columns(): array
    {

        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button data-modal-target="modal-editar-categoria" data-modal-toggle="modal-editar-categoria" type="button"  wire:click="traerCategoria(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
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


    public function traerCategoria($id)
    {
        $this->dispatch('traerCategoria', id: $id);
    }

    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $categoria = CategoriasModel::find($id);
        $categoria->estado = $estado;
        $categoria->save();
    }
}
