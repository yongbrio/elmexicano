<?php

namespace App\Livewire\Administracion\Perfiles;

use App\Models\PerfilesModel;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use Spatie\Permission\Models\Role;

class ListaPerfilesTable extends LivewireTable
{
    protected string $model = PerfilesModel::class;

    protected function columns(): array
    {

        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button data-modal-target="modal-editar-perfil" data-modal-toggle="modal-editar-perfil" type="button"  wire:click="traerPerfil(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('ID'), 'id')->sortable()->searchable(),
            Column::make(__('Nombre del perfil'), function (mixed $value) {
                $role = Role::find($value->id_rol);
                return $role->name;
            })->sortable()->searchable(),
            Column::make(__('Permisos'), function (mixed $value): string {
                return '<button data-modal-target="modal-asignar-permiso" data-modal-toggle="modal-asignar-permiso" type="button" wire:click="asignarPermisosRol(' . $value->id_rol . ')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i class="fa-solid fa-circle-plus"></i> Asignar permisos</button>';
            })->asHtml(),
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


    public function traerPerfil($id)
    {
        $this->dispatch('traerPerfil', id: $id);
    }

    public function asignarPermisosRol($id)
    {
        $this->dispatch('asignarPermisosRol', role_id: $id);
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

        $perfil = PerfilesModel::find($id);
        $perfil->estado = $estado;
        $perfil->save();
    }
}
