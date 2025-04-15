<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\HistorialTransferenciasModel;
use App\Models\SucursalesModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Enums\Direction;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaTransferenciasInventarioTable extends LivewireTable
{
    protected string $model = HistorialTransferenciasModel::class;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        if (Auth::user()->perfil == 1) {
            return $this->model()->query()->where('transferencia_recibida', '<>', 0);
        } else {
            return $this->model()->query()->where('id_sucursal_destino', '=', Auth::user()->caja)->where('transferencia_recibida', '<>', 0)
                ->orWhere('id_sucursal_origen', '=', Auth::user()->caja)->where('transferencia_recibida', '<>', 0);
        }
    }

    protected function columns(): array
    {
        return [
            Column::make(__('Producto'), function ($value) {
                return $value->codigo_producto . " - " . $value->nombre_producto;
            })->sortable()->searchable(),

            Column::make(__('Sucursal Origen'), 'nombre_sucursal_origen')->sortable()->searchable(),

            Column::make(__('Cantidad transferida'), 'cantidad_transferida')->sortable()->searchable(),

            Column::make(__('Movimiento'), function ($value) {

                $estado = "Entrada";
                $color = 'green-600';

                if ($value->id_sucursal_origen == Auth::user()->caja) {
                    $estado = "Salida";
                    $color = 'red-600';
                }

                // Devuelve el HTML para mostrar
                return "<div class='text-white p-1 bg-{$color} rounded px-2 text-center'>
                {$estado}
                </div>";  // Devuelve el HTML formateado


            })->asHtml()->sortable(function (Builder $builder, Direction $direction): void {
                // Utiliza la columna original para el ordenamiento
                $builder->orderBy('transferencia_recibida', $direction->value);
            })->searchable(function (Builder $builder, $searchTerm) {
                $builder->where('transferencia_recibida', 'LIKE', "%{$searchTerm}%");
            }),

            Column::make(__('Estado de transferencia'), function ($value) {

                $estado = "En tránsito";
                $color = 'yellow-400';

                if ($value->transferencia_recibida == 2) {
                    $estado = "Recibida";
                    $color = 'green-600';
                } else if ($value->transferencia_recibida == 3) {
                    $estado = "Rechazado";
                    $color = 'red-600';
                }

                // Devuelve el HTML para mostrar
                return "<div class='text-white p-1 bg-{$color} rounded px-2 text-center'>
                {$estado}
                </div>";  // Devuelve el HTML formateado


            })->asHtml()->sortable(function (Builder $builder, Direction $direction): void {
                // Utiliza la columna original para el ordenamiento
                $builder->orderBy('transferencia_recibida', $direction->value);
            })->searchable(function (Builder $builder, $searchTerm) {
                $builder->where('transferencia_recibida', 'LIKE', "%{$searchTerm}%");
            }),

            Column::make(__('Usuario aprobación'), function ($value) {
                $usuario = User::find($value->usuario_aprobacion);
                return $usuario ? $usuario->name . " " . $usuario->apellidos : "Sin asignar";
            })->sortable()->searchable(),

            Column::make(__('Fecha de aprobacion'), 'created_at')->sortable()->searchable(),

            Column::make(__('Sucursal Destino'), 'nombre_sucursal_destino')->sortable()->searchable(),

            Column::make(__('Registrado por'), function ($value) {
                $usuario = User::find($value->registrado_por);
                return $usuario->name . " " . $usuario->apellidos;
            })->sortable()->searchable(),

            Column::make(__('Fecha de registro'), 'created_at')->sortable()->searchable(),


        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }


    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }
}
