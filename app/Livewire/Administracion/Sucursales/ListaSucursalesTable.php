<?php

namespace App\Livewire\Administracion\Sucursales;

use App\Models\SucursalesModel;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaSucursalesTable extends LivewireTable
{
    protected string $model = SucursalesModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="editarSucursal(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('Identificador'), 'identificador')->sortable()->searchable(),
            Column::make(__('Nombre Sucursal'), 'nombre_sucursal')->sortable()->searchable(),
            Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
            Column::make(__('Ciudad'), 'ciudad')->sortable()->searchable(),
            Column::make(__('Departamento'), 'departamento')->sortable()->searchable(),
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

    public function editarSucursal($id)
    {
        return redirect()->route('editar-sucursal', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $cliente = SucursalesModel::find($id);
        $cliente->estado = $estado;
        $cliente->save();
    }
}
