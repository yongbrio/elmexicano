<?php

namespace App\Livewire\Administracion\AprobarOrdenes;


use App\Models\OrdenesModel;
use App\Models\PagosOrdenes;
use App\Models\SucursalesModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Enums\Direction;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaAprobarOrdenes extends LivewireTable
{
    protected string $model = OrdenesModel::class;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        return $this->model()->query()->where('forma_pago', '=', 'banco')->where('estado_orden', '=', 1);
    }

    protected function columns(): array
    {
        return [

            Column::make(__('ID'), function ($value) {
                $datos = json_decode($value->datos);
                return $datos->telefono;
            })
                ->searchable(function ($query, $search) {
                    $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(datos, "$.telefono")) LIKE ?', ["%{$search}%"]);
                })
                ->sortable(function (Builder $builder, Direction $direction) {
                    $builder->selectRaw('id, datos, JSON_UNQUOTE(JSON_EXTRACT(datos, "$.telefono")) AS telefono')
                        ->orderBy('telefono', $direction->value);
                }),

            Column::make(__('Grupo'), function ($value) {
                $datos = json_decode($value->datos);
                return strtoupper($datos->grupo);
            })
                ->searchable(function ($query, $search) {
                    $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(datos, "$.grupo")) LIKE ?', ["%{$search}%"]);
                })
                ->sortable(function (Builder $builder, Direction $direction) {
                    $builder->selectRaw('id, datos, JSON_UNQUOTE(JSON_EXTRACT(datos, "$.grupo")) AS grupo')
                        ->orderBy('grupo', $direction->value);
                }),

            Column::make(__('Nombre comercial'), function ($value) {
                $datos = json_decode($value->datos);
                return strtoupper($datos->nombre_comercial);
            })
                ->searchable(function ($query, $search) {
                    $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(datos, "$.nombre_comercial")) LIKE ?', ["%{$search}%"]);
                })
                ->sortable(function (Builder $builder, Direction $direction) {
                    $builder->selectRaw('id, datos, JSON_UNQUOTE(JSON_EXTRACT(datos, "$.nombre_comercial")) AS nombre_comercial')
                        ->orderBy('nombre_comercial', $direction->value);
                }),

            Column::make(__('Nombre legal'), function ($value) {
                $datos = json_decode($value->datos);
                return strtoupper($datos->nombre_legal);
            })
                ->searchable(function ($query, $search) {
                    $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(datos, "$.nombre_legal")) LIKE ?', ["%{$search}%"]);
                })
                ->sortable(function (Builder $builder, Direction $direction) {
                    $builder->selectRaw('id, datos, JSON_UNQUOTE(JSON_EXTRACT(datos, "$.nombre_legal")) AS nombre_legal')
                        ->orderBy('nombre_legal', $direction->value);
                }),

            Column::make(__('Orden'), function ($value) {
                $orden = trim($value->id);
                $tipo = trim($value->tipo_orden);
                $enlace = sprintf(
                    '<a href="%s" target="_blank">%s</a>',
                    route('ordenes-' . $tipo, ['id' => $orden]),
                    $orden
                );
                return sprintf("<div class='p-1 px-2 text-center text-white bg-blue-700 rounded'>%s</div>", $enlace);
            })->asHtml()->sortable(function (Builder $builder, Direction $direction) {
                $builder->orderBy('id', $direction->value);
            })->searchable(function ($query, $search) {
                $query->where('id', 'LIKE', "%{$search}%");
            }),

            Column::make(__('Sucursal'),  function ($value) {
                $sucursal = SucursalesModel::find($value->id_sucursal);
                return  strtoupper($sucursal->nombre_sucursal);
            })->searchable(),

            Column::make(__('Factura con'), function ($value) {
                $datos = json_decode($value->datos_empresa);
                return strtoupper($datos->nombre_comercial);
            })->searchable(function ($query, $search) {
                $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(datos_empresa, "$.nombre_comercial")) LIKE ?', ["%{$search}%"]);
            })->sortable(function (Builder $builder, Direction $direction) {
                $builder->selectRaw('id, datos_empresa, JSON_UNQUOTE(JSON_EXTRACT(datos_empresa, "$.nombre_comercial")) AS nombre_comercial')
                    ->orderBy('nombre_comercial', $direction->value);
            }),

            Column::make(__('Items'), function ($value) {
                $detalle = json_decode($value->detalle);
                $totalCantidad = 0;

                // Verifica que $detalle no esté vacío y sea un array
                if (!empty($detalle) && is_array($detalle)) {
                    foreach ($detalle as $producto) {
                        // Verifica que cada producto tenga la propiedad 'cantidad_producto'
                        if (isset($producto->cantidad_producto)) {
                            $totalCantidad += $producto->cantidad_producto;
                        }
                    }
                }

                return $totalCantidad;
            })->searchable(function ($query, $search) {
                $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(detalle, "$[*].cantidad_producto")) LIKE ?', ["%{$search}%"]);
            })->sortable(function (Builder $builder, Direction $direction) {
                $builder->selectRaw('id, detalle, 
                        (SELECT SUM(JSON_UNQUOTE(JSON_EXTRACT(value, "$.cantidad_producto"))) 
                         FROM JSON_TABLE(detalle, "$[*]" COLUMNS (value JSON PATH "$")) AS jt) AS total_cantidad')
                    ->from('ordenes') // Cambia 'ordenes' por el nombre real de tu tabla
                    ->orderBy('total_cantidad', $direction->value);
            }),

            Column::make(__('Usuario'), function ($value) {
                $usuario = User::find($value->registrado_por);
                return strtoupper($usuario->username);
            })->searchable(function ($query, $search) {
                $query->whereHas('usuario', function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%");
                });
            })->sortable(function (Builder $builder, Direction $direction) {
                $builder->join('users', 'ordenes.registrado_por', '=', 'users.id') // Cambia 'ordenes' por el nombre real de tu tabla
                    ->selectRaw('ordenes.*, users.username')
                    ->orderBy('users.username', $direction->value);
            }),

            Column::make(__('Total'), function ($value) {
                $detalle = json_decode($value->detalle);
                $suma = 0;
                if (!empty($detalle)) {
                    foreach ($detalle as $prod) {
                        $suma += $prod->total;
                    }
                }

                $color = '';
                $tipo = strtoupper(trim($value->tipo_orden));
                // Asignar color según el tipo de orden
                if ($tipo === 'EGRESO') {
                    $color = 'red-600'; // Ejemplo para tipo Egreso
                } elseif ($tipo === 'INGRESO') {
                    $color = 'green-600'; // Ejemplo para tipo Ingreso
                }
                return "<div class='text-{$color}'>" . number_format($suma, 2, '.', ',') . "</div>";
            })->asHtml()
                ->searchable(function (Builder $builder, $searchTerm) {
                    $builder->whereRaw("JSON_SEARCH(detalle, 'one', ?) IS NOT NULL", ["%{$searchTerm}%"]);
                })
                ->sortable(function (Builder $builder, Direction $direction) {
                    $builder->selectRaw('id, detalle, (
                        SELECT COALESCE(SUM(
                            CASE 
                                WHEN tipo_orden = "EGRESO" THEN -JSON_UNQUOTE(JSON_EXTRACT(value, "$.total"))
                                ELSE JSON_UNQUOTE(JSON_EXTRACT(value, "$.total"))
                            END
                        ), 0) 
                        FROM JSON_TABLE(detalle, "$[*]" COLUMNS (value JSON PATH "$")) AS jt
                    ) AS total_sum')
                        ->from('ordenes') // Cambia 'ordenes' por el nombre real de tu tabla
                        ->orderBy('total_sum', $direction->value);
                }),

            Column::make(__('Acciones'), function ($value) {

                $archivo_orden = json_decode($value->adjuntos);

                $archivo_orden = $archivo_orden[0];

                $boton_aprobar = '<button id="btnAprobar_' . $archivo_orden->id . '" wire:click="validarOrden(' . $value->id . ')"
                class="inline-flex justify-center p-2 text-green-600 rounded-full cursor-pointer hover:bg-green-100 dark:text-green-500 dark:hover:bg-gray-600">
                    <i class="fa-solid fa-circle-check"></i>
                </button>';

                $boton_ver = '<button id="btnPreview_pago' . $archivo_orden->id . '"
                            data-file-url="' . route('admin.storage', ['modulo' => 'ingresos', 'filename' => $archivo_orden->nombre]) . '"
                            data-file-type="' . $archivo_orden->fileType . '" type="button"
                            x-on:click="modalPreview(\'' . $archivo_orden->id . '\', \'pago\')"
                            data-modal-target="modal-preview-soporte"
                            data-modal-toggle="modal-preview-soporte"
                            class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                            <i class="fa-solid fa-eye"></i>
                            <span class="sr-only">Ver</span>
                        </button>';

                return '<div class="d-flex">' . $boton_aprobar . $boton_ver . '</div>';
            })->asHtml(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

    public function validarOrden($id_orden)
    {
        $orden = OrdenesModel::find($id_orden);
        $orden->estado_pago = 'validado';
        $orden->estado_orden = '2';
        $orden->save();

        $pago = PagosOrdenes::where('orden', $orden->id)->first();
        $pago->id_estado_pago = 2;
        $pago->nombre_estado_pago = 'validado';
        $pago->save();

        $message = 'Orden Aprobada';
        $icon = 'success';
        $this->dispatch('mensajes', message: $message, icon: $icon, state: false);

        $this->columns();
    }
}
