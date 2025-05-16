<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\HistorialTransferenciasModel;
use App\Models\InventarioModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Enums\Direction;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaTransferenciasInventario extends LivewireTable
{
    protected string $model = HistorialTransferenciasModel::class;

    public $estado;

    public function mount(int $estado)
    {
        $this->estado = $estado;
    }

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        //Si el usuario es administrador o si el usuario tiene asignado la sucursal corporativa, la sucursal corporativo siempre debe ser 1
        if (Auth::user()->perfil == 1 || Auth::user()->caja == 1) {
            return $this->model()->query()->where('transferencia_recibida', '=', $this->estado);
        } else {
            $consulta = $this->model()::query();

            if ($this->estado == 0) {
                $consulta = $consulta
                    ->where('id_sucursal_origen', '=', Auth::user()->caja)
                    ->where('transferencia_recibida', '=', $this->estado);
            } else if ($this->estado == 1 || $this->estado == 2) {
                $consulta = $consulta
                    ->where(function ($query) {
                        $query->where('id_sucursal_destino', '=', Auth::user()->caja)
                            ->orWhere('id_sucursal_origen', '=', Auth::user()->caja);
                    })
                    ->where('transferencia_recibida', '=', $this->estado);
            } else {
                $consulta = $consulta->whereRaw('1 = 0');
            }


            return $consulta;
        }
    }

    protected function columns(): array
    {
        return [

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
            Column::make(__('Sucursal Origen'), 'nombre_sucursal_origen')->sortable()->searchable(),
            Column::make(__('Producto'), function ($value) {
                return $value->codigo_producto . " - " . $value->nombre_producto;
            })->sortable()->searchable(),
            Column::make(__('Cantidad'), 'cantidad_transferida')->sortable()->searchable(),
            Column::make(__('Sucursal Destino'), 'nombre_sucursal_destino')->sortable()->searchable(),

            Column::make(__('Registrado por'), function ($value) {
                $usuario = User::find($value->registrado_por);
                return $usuario->name . " " . $usuario->apellidos;
            })->sortable()->searchable(),

            Column::make(__('Fecha de registro'), 'created_at')->sortable()->searchable(),
            Column::make(__('Acciones'), function ($value) {

                $acciones = [
                    0 => [
                        'texto1' => 'Enviar transferencia',
                        'icono1' => "<i class='fa-solid fa-paper-plane'></i>",
                        'texto2' => 'Cancelar transferencia',
                        'icono2' => "<i class='fa-solid fa-circle-xmark'></i>",
                    ],
                    1 => [
                        'texto1' => 'Aceptar transferencia',
                        'icono1' => "<i class='fa-solid fa-thumbs-up'></i>",
                        'texto2' => 'Rechazar transferencia',
                        'icono2' => "<i class='fa-solid fa-ban'></i>",
                    ],
                ];

                $texto_boton1 = $acciones[$this->estado]['texto1'] ?? '';
                $icono_boton1 = $acciones[$this->estado]['icono1'] ?? '';
                $texto_boton2 = $acciones[$this->estado]['texto2'] ?? '';
                $icono_boton2 = $acciones[$this->estado]['icono2'] ?? '';

                $botonAceptar = "
                    <button wire:click=\"crearTransferencia({$value->id})\" 
                            class='px-2 py-1 font-bold text-white bg-green-600 rounded hover:bg-green-700' 
                            title='$texto_boton1'>
                        $icono_boton1
                    </button>";

                $botonRechazar = "
                    <button wire:click=\"eliminarTransferencia({$value->id},{$this->estado})\" 
                            class='px-2 py-1 font-bold text-white bg-red-600 rounded hover:bg-red-700' 
                            title='$texto_boton2'>
                        $icono_boton2
                    </button>";

                $botones = '';

                if ($this->estado == 0) {
                    $botones = "<div class='flex gap-2'>{$botonAceptar}{$botonRechazar}</div>";
                } elseif ($this->estado == 1) {
                    $esAdminOCorporativo = Auth::user()->perfil == 1 || Auth::user()->caja == 1;

                    if ($esAdminOCorporativo) {
                        $botones = "<div class='flex gap-2'>{$botonAceptar}{$botonRechazar}</div>";
                    } else if ($value->id_sucursal_origen == Auth::user()->caja) {
                        $botonRechazar = "
                        <button wire:click=\"eliminarTransferencia({$value->id},{$this->estado})\" 
                                class='px-2 py-1 font-bold text-white bg-red-600 rounded hover:bg-red-700' 
                                title='Cancelar transferencia'>
                            {$icono_boton2}
                        </button>";
                        $botones = "<div class='flex gap-2'>{$botonRechazar}</div>";
                    } else {
                        $botones = "<div class='flex gap-2'>{$botonAceptar}</div>";
                    }
                }

                return $botones;
            })->asHtml(),

        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

    public function eliminarTransferencia($id, $estado)
    {

        $historial = HistorialTransferenciasModel::where('id', $id)->first();

        if ($historial) {
            //Actualizamos el stock del inventario origen
            $inventario = InventarioModel::where('codigo_producto', $historial->codigo_producto)->where('sucursal', $historial->id_sucursal_origen)->first();

            $inventario->stock = $inventario->stock + $historial->cantidad_transferida;
            $inventario->save();
            //Actualizamos el estado de la transferencia como rechazado
            $historial->transferencia_recibida = 3;
            if ($estado == 0) {
                //Cancelado por el usuario
                $historial->transferencia_recibida = 4;
            }
            $historial->usuario_aprobacion = Auth::user()->id;
            $historial->save();

            //Recargar la lista de inventario
            $this->dispatch('recargarComponente');
            $message = "Ha rechazado la transferencia del inventario";
            $estado_mensaje = "Rechazado";
            if ($estado == 0) {
                $message = "Ha cancelado la transferencia del inventario";
                $estado_mensaje = "Cancelado";
            }
            $this->dispatch('estadoActualizacion_tabla', title: $estado_mensaje, icon: 'error', message: $message);
            //Actualizamos la lista con los registros
            $this->dispatch('actualizarTransferencias');
        }
    }

    public function crearTransferencia($id)
    {
        //Consultamos el registro
        $transferencia = HistorialTransferenciasModel::where('id', $id)->first();
        $estado_transferencia = -1;
        if ($this->estado == 0) {
            $estado_transferencia = 1;
        } else if ($this->estado == 1) {
            $estado_transferencia = 2;
        }
        if ($transferencia) {

            //Actualización del producto de la sucursal destino
            $producto_destino = InventarioModel::where('codigo_producto', $transferencia->codigo_producto)->where('sucursal', $transferencia->id_sucursal_destino)->first();
            if ($estado_transferencia == 2) {
                $nuevoStock = $producto_destino->stock + $transferencia->cantidad_transferida;
                $producto_destino->stock = $nuevoStock;
            }

            $producto_destino->save();
            //La transferencia ha sido aceptada
            $transferencia->transferencia_recibida = $estado_transferencia;
            $transferencia->usuario_aprobacion = Auth::user()->id;
            $transferencia->save();
            $estado_mensaje = "Creado";
            $message = "El inventario se ha transferido y está en transito";
            if ($estado_transferencia == 2) {
                $estado_mensaje = "Aceptado";
                $message = "El inventario se ha aceptado y ya se encuentra disponible";
            }
            $this->dispatch('estadoActualizacion_tabla', title: $estado_mensaje, icon: 'success', message: $message);
            //Recargar la lista de inventario
            $this->dispatch('recargarComponente');
            //Actualizamos la lista con los registros
            $this->dispatch('actualizarTransferencias');
        } else {
            $message = "Ocurrió un problema. vuelva a intentarlo";
            $this->dispatch('estadoActualizacion_tabla', title: "¡Error!", icon: 'error', message: $message);
        }
    }

    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }
}
