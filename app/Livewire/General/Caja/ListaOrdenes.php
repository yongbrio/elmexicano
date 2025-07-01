<?php

namespace App\Livewire\General\Caja;

use App\Models\OrdenesModel;
use App\Models\SucursalesModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Enums\Direction;
use stdClass;

class ListaOrdenes extends LivewireTable
{
    protected string $model = OrdenesModel::class;

    protected $appends = ['tipo_orden'];

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        $sucursal_usuario = SucursalesModel::find(Auth::user()->caja);

        if (strtolower($sucursal_usuario->nombre_sucursal) == 'corporativo') {
            return $this->model()->query();
        } else {
            return $this->model()->query()->where('ordenes.id_sucursal', '=', Auth::user()->caja);
        }
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

            Column::make(__('Tipo'), function ($value) {
                $tipo = strtoupper(trim($value->tipo_orden));
                $color = '';

                // Asignar color según el tipo de orden
                if ($tipo === 'EGRESO') {
                    $color = 'red-600'; // Ejemplo para tipo Egreso
                } elseif ($tipo === 'INGRESO') {
                    $color = 'green-600'; // Ejemplo para tipo Ingreso
                }

                // Devuelve el HTML para mostrar
                return "<div class='text-white p-1 bg-{$color} rounded px-2 text-center'>
                {$tipo}
                </div>";  // Devuelve el HTML formateado
            })->asHtml()->sortable(function (Builder $builder, Direction $direction): void {
                // Utiliza la columna original para el ordenamiento
                $builder->orderBy('tipo_orden', $direction->value);
            })->searchable(function (Builder $builder, $searchTerm) {
                $builder->where('tipo_orden', 'LIKE', "%{$searchTerm}%");
            }),

            Column::make(__('Forma pago'), function ($value) {
                $tipo = strtoupper(trim($value->forma_pago));
                $tipo = empty($tipo) ? 'SIN ASIGNAR' : $tipo;
                $color = '';

                // Asignar color según el tipo de orden
                if ($tipo === 'CREDITO') {
                    $color = 'yellow-400';
                } else if ($tipo === 'EFECTIVO') {
                    $color = 'purple-700';
                } else if ($tipo === 'BANCO') {
                    $color = 'blue-700';
                } else {
                    $color = 'gray-400';
                }

                // Devuelve el HTML para mostrar
                return "<div class='text-white p-1 bg-{$color} rounded px-2 text-center'>
                {$tipo}
                </div>";  // Devuelve el HTML formateado
            })->asHtml()->sortable(function (Builder $builder, Direction $direction): void {
                // Utiliza la columna original para el ordenamiento
                $builder->orderBy('forma_pago', $direction->value);
            })->searchable(function (Builder $builder, $searchTerm) {
                $builder->where('forma_pago', 'LIKE', "%{$searchTerm}%");
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

            Column::make(__('Estado envío'), function ($value) {
                $estados = [
                    0 => 'Por despachar',
                    1 => 'Despachado',
                    2 => 'Cargar comprobante',
                    3 => 'Conciliado',
                ];
                return isset($estados[$value->estado_envio]) ? $estados[$value->estado_envio] : 'Por asignar';
            })->searchable(function ($query, $search) {
                $search = strtolower($search);

                // Definir los estados posibles
                $estados = [
                    'Por despachar',
                    'Despachado',
                    'Cargar comprobante',
                    'Conciliado',
                    'Por asignar',
                ];

                // Construir la consulta
                $query->where(function ($query) use ($search, $estados) {
                    // Comparar los estados y permitir buscar por "Por asignar"
                    foreach ($estados as $key => $estado) {
                        if (stripos($estado, $search) !== false) {
                            $query->orWhere('estado_envio', $key);
                        }
                    }

                    // Para los casos en que el estado_envio está vacío
                    if (empty($search) || stripos('Por asignar', $search) !== false) {
                        $query->orWhere('estado_envio', '');
                    }
                });
            })->sortable(function (Builder $builder, Direction $direction) {
                // Ordenamiento por estado_envio
                $builder->orderBy('estado_envio', $direction->value);
            }),


            Column::make(__('Estado pago'), function ($value) {
                // Verifica si estado_pago está vacío
                return !empty($value->estado_pago) ? ucfirst(strtolower($value->estado_pago)) : 'Por asignar';
            })->searchable(function ($query, $search) {
                // Búsqueda por estado_pago
                $query->where(function ($query) use ($search) {
                    // Busca el estado_pago o considera vacío como "Por asignar"
                    $query->where('estado_pago', 'LIKE', "%{$search}%")
                        ->orWhere(function ($query) use ($search) {
                            // Considera los valores vacíos como "Por asignar"
                            $query->where('estado_pago', '')
                                ->whereRaw('LOWER(?) = LOWER("Por asignar")', [$search]);
                        });
                });
            })->sortable(function (Builder $builder, Direction $direction) {
                // Ordenamiento por estado_pago
                $builder->orderBy('estado_pago', $direction->value);
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
                })


        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }
}
