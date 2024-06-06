<?php

namespace App\Livewire\General\Clientes;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;

class ListaClientes extends LivewireTable
{
    protected string $model = ClientesModel::class;

    #[Locked]
    public int $estado;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        return $this->model()->query()->where('estado', '=', 1);
    }

    protected function columns(): array
    {

        return [

            Column::make(__('Nombre Comercial'), 'nombre_comercial')->sortable()->searchable(),
            Column::make(__('Nombre Legal'), 'nombre_legal')->sortable()->searchable(),
            Column::make(__('Grupo'), 'grupo')->sortable()->searchable(),
            Column::make(__('Teléfono'), 'telefono')->sortable()->searchable(),
            Column::make(__('NIT'), 'nit')->sortable()->searchable(),
            Column::make(__('Sucursal'), 'sucursal')->sortable()->searchable(),
            Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
            Column::make(
                __('Ciudad'),
                function (mixed $value) {
                    $nombreCiudad = MunicipiosModel::where('id', $value->ciudad)->first();
                    return $nombreCiudad->nombre_municipio;
                }
            )->sortable()->searchable(),
            Column::make(
                __('Departamento'),
                function (mixed $value) {
                    $nombreDpto = DepartamentosModel::where('id', $value->departamento)->first();
                    return $nombreDpto->nombre_departamento;
                }
            )->sortable()->searchable(),
            Column::make(__('Correo'), 'correo')->sortable()->searchable(),
            Column::make(__('Nombre encargado'), 'nombre_encargado')->sortable()->searchable(),
            Column::make(__('Descripción'), 'descripcion')->sortable()->searchable(),
            /* Column::make(__('Factura con'), 'empresa_factura')->sortable()->searchable(), */
            Column::make(__('Factura con'),  function (mixed $value): string {
                $nombreEmpresa = EmpresasModel::select('nombre_comercial')->where('id', $value->empresa_factura)->first();
                return  $nombreEmpresa->nombre_comercial;
            })->sortable()->searchable(),
            Column::make(__('Importancia'), 'importancia')->sortable()->searchable(),
            Column::make(__('Estado'), function (mixed $value, ClientesModel $model): string {

                $estado = "";

                if ($value->estado == 1) {
                    $estado = "Activo";
                } else {
                    $estado = "Inactivo";
                }

                return $estado;
            }),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }


    protected function activado()
    {
        return true;
    }
}
