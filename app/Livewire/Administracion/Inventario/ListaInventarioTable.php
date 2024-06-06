<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\CategoriasModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\TipoProductoModel;
use App\Models\UnidadesMedidaModel;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaInventarioTable extends LivewireTable
{

    protected string $model = InventarioModel::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="editarInventario(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('Imagen'), function ($value) {
                if ($value->imagen != '') {
                    $path = $value->imagen;
                    $moduleName = 'productos'; // Nombre del módulo
                    $imageName = basename($path);
                    // Clases de Tailwind para hover y transición
                    return '<img class="w-10 h-10 transition duration-300 ease-in-out transform rounded-full cursor-pointer hover:scale-110" src="' . route("admin.storage", ["modulo" => $moduleName, "filename" => $imageName]) . '" alt="image description">';
                } else {
                    return '<img class="w-10 h-10 transition duration-300 ease-in-out transform rounded-full cursor-pointer hover:scale-110" src="' . asset('images/imagen-defecto-producto.jpg') . '" alt="image description">';
                }
            })->asHtml(),
            Column::make(__('Sucursal'), function ($value) {
                $sucursal = SucursalesModel::find($value->sucursal);
                return $sucursal->nombre_sucursal;
            })->sortable()->searchable(),
            Column::make(__('Código del producto'), 'codigo_producto')->sortable()->searchable(),
            Column::make(__('Categoría'), function ($value) {
                $categoria = CategoriasModel::find($value->categoria);
                return $categoria->nombre_categoria;
            })->sortable()->searchable(),
            Column::make(__('Tipo de producto'), function ($value) {
                $tipo_producto = TipoProductoModel::find($value->tipo_producto);
                return $tipo_producto->nombre_tipo_producto;
            })->sortable()->searchable(),
            Column::make(__('Nombre del producto'), 'descripcion')->sortable()->searchable(),
            Column::make(__('Tipo de impuesto'), function ($value) {
                $tipo_impuesto = TipoAfectacionImpuestoModel::find($value->tipo);
                return $tipo_impuesto->codigo . " - " . $tipo_impuesto->descripcion;
            })->sortable()->searchable(),
            Column::make(__('Unidad de medida'), function($value){
                $unidad_medida = UnidadesMedidaModel::find($value->unidad_medida);
                return $unidad_medida->nombre_unidad_medida;
            })->sortable()->searchable(),
            Column::make(__('Costo Unitario'), 'costo_unitario')->sortable()->searchable(),
            Column::make(__('Precio (con IVA)'), 'precio_unitario_con_iva')->sortable()->searchable(),
            Column::make(__('Precio (sin IVA)'), 'precio_unitario_sin_iva')->sortable()->searchable(),
            Column::make(__('Comisión'), 'comision')->sortable()->searchable(),
            Column::make(__('Stock'), 'stock')->sortable()->searchable(),
            Column::make(__('Min Stock'), 'stock_minimo')->sortable()->searchable(),

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

    public function editarInventario($id)
    {
        return redirect()->route('editar-inventario', ['id' => $id]);
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

        $cliente = InventarioModel::find($id);
        $cliente->estado = $estado;
        $cliente->save();
    }
}
