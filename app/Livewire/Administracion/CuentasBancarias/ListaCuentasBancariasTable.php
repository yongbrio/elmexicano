<?php

namespace App\Livewire\Administracion\CuentasBancarias;

use App\Models\CuentasBancariasModel;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaCuentasBancariasTable extends LivewireTable
{
    protected string $model = CuentasBancariasModel::class;

    protected function columns(): array
    {

        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="editarCuentaBancaria(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('Empresa'), 'obtenerEmpresa.nombre_comercial')->sortable()->searchable(),
            Column::make(__('Número de cuenta'), 'numero_cuenta')->sortable()->searchable(),
            Column::make(__('Banco'), 'nombre_banco')->sortable()->searchable(),
            DateColumn::make(__('Fecha de apertura'), 'fecha_apertura')
                ->format('d/m/Y')->sortable()->searchable(),
            Column::make(__('Tipo de Cuenta'), function (mixed $value) {
                $tipos_cuenta = ["Ahorros", "Corriente", "Tarjeta de Crédito", "Cuenta Internacional", "Cuenta de Inversión", "Crédito rotativo"];
                return $tipos_cuenta[$value->tipo_cuenta - 1];
            })->sortable()->searchable(),
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

    public function editarCuentaBancaria($id)
    {
        return redirect()->route('editar-cuenta-bancaria', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $cuenta = CuentasBancariasModel::find($id);
        $cuenta->estado = $estado;
        $cuenta->save();
    }
}
