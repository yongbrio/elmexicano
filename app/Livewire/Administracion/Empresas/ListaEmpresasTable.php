<?php

namespace App\Livewire\Administracion\Empresas;

use App\Models\EmpresasModel;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaEmpresasTable extends LivewireTable
{
    protected string $model = EmpresasModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value, EmpresasModel $model): string {
                return '<button type="button" wire:click="editarEmpresa(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('NIT'), 'nit')->sortable()->searchable(),
            Column::make(__('Nombre Legal'), 'nombre_legal')->sortable()->searchable(),
            Column::make(__('Nombre Comercial'), 'nombre_comercial')->sortable()->searchable(),
            Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
            Column::make(__('Departamento'), 'departamento')->sortable()->searchable(),
            Column::make(__('Ciudad'), 'ciudad')->sortable()->searchable(),
            Column::make(__('Matricula'), 'matricula')->sortable()->searchable(),
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

    public function editarEmpresa($id)
    {
        return redirect()->route('editar-empresa', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        $accion = "";

        if ($estado == 0) {
            $estado = 1;
            $accion = "Activar Empresa";
        } else {
            $estado = 0;
            $accion = "Desactivar Empresa";
        }

        $empresa = EmpresasModel::find($id);
        $empresa->estado = $estado;
        $empresa->save();
    }
}
