<?php

namespace App\Livewire;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\ViewColumn;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use Livewire\WithPagination;


class ListaClientesTable extends LivewireTable
{
   protected string $model = ClientesModel::class;

   use WithPagination;

   protected function columns(): array
   {

      return [
         Column::make(__('Acciones'), function (mixed $value, ClientesModel $model): string {
            return '<button type="button" wire:click="editarCliente(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
         })->asHtml(),
         Column::make(__('Teléfono'), 'telefono')->sortable()->searchable(),
         Column::make(__('Grupo'), 'grupo')->sortable()->searchable(),
         Column::make(__('Nombre Comercial'), 'nombre_comercial')->sortable()->searchable(),
         Column::make(__('Nombre Legal'), 'nombre_legal')->sortable()->searchable(),
         Column::make(__('NIT'), 'nit')->sortable()->searchable(),
         Column::make(__('Sucursal'), 'sucursal')->sortable()->searchable(),
         Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
         Column::make(__('Ciudad'), 'ciudad')->sortable()->searchable(),
         Column::make(__('Departamento'), 'departamento')->sortable()->searchable(),
         Column::make(__('Correo'), 'correo')->sortable()->searchable(),
         Column::make(__('Nombre encargado'), 'nombre_encargado')->sortable()->searchable(),
         Column::make(__('Descripción'), 'descripcion')->sortable()->searchable(),
         /* Column::make(__('Factura con'), 'empresa_factura')->sortable()->searchable(), */
         Column::make(__('Factura con'),  function (mixed $value): string {
            $nombreEmpresa = EmpresasModel::select('nombre_comercial')->where('id', $value->empresa_factura)->first();
            return  $nombreEmpresa->nombre_comercial;
         })->sortable()->searchable(),
         Column::make(__('Importancia'), 'importancia')->sortable()->searchable(),
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

   public function editarCliente($id)
   {
      return redirect()->route('editar-cliente', ['id' => $id]);
   }

   public function cambiarEstado($id, $estado)
   {
      if ($estado == 0) {
         $estado = 1;
      } else {
         $estado = 0;
      }
      
      $cliente = ClientesModel::find($id);
      $cliente->estado = $estado;
      $cliente->save();
   }
}
