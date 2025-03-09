<?php

namespace App\Livewire\Administracion\Sucursales;

use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
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
            Column::make(__('Barrio/Localidad'), 'barrio_localidad')->sortable()->searchable(),
            Column::make(
                __('Ciudad'),
                function (mixed $value) {
                    $nombreCiudad = MunicipiosModel::where('id', $value->ciudad)->first();
                    if ($nombreCiudad) {
                        return $nombreCiudad->nombre_municipio;
                    } else {
                        return '';
                    }
                }
            )->sortable()->searchable(),

            Column::make(
                __('Departamento'),
                function (mixed $value) {
                    $nombreDpto = DepartamentosModel::where('id', $value->departamento)->first();
                    if ($nombreDpto) {
                        return $nombreDpto->nombre_departamento;
                    } else {
                        return '';
                    }
                }
            )->sortable()->searchable(),

            Column::make(__('Giro sucursal'), 'giroSucursal.descripcion')
                ->qualifyUsingAlias()
                ->sortable()
                ->searchable(),

            Column::make(__('Tipo sucursal'), 'tipoSucursal.descripcion')
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

    public function editarSucursal($id)
    {
        return redirect()->route('editar-sucursal', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        $accion = '';

        if ($estado == 0) {
            $estado = 1;
            $accion = 'Activar Sucursal';
        } else {
            $estado = 0;
            $accion = 'Desactivar Sucursal';
        }

        $sucursal = SucursalesModel::find($id);
        $sucursal->estado = $estado;
        $sucursal->save();
    }
}
