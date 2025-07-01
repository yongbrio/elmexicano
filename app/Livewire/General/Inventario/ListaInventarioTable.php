<?php

namespace App\Livewire\General\Inventario;

use App\Models\CategoriasModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\TipoProductoModel;
use App\Models\UnidadesMedidaModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaInventarioTable extends LivewireTable
{
    protected string $model = InventarioModel::class;

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        $sucursal_usuario = SucursalesModel::find(Auth::user()->caja);

        if (strtolower($sucursal_usuario->nombre_sucursal) == 'corporativo') {
            return $this->model()->query();
        } else {
            return $this->model()->query()->where('inventario.estado', '=', 1)->where('inventario.sucursal_id', '=', Auth::user()->caja)->with(['sucursal', 'registro', 'producto.categorias']);
        }
    }

    protected function columns(): array
    {
        return [
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
            Column::make(__('Sucursal'), 'sucursal.nombre_sucursal')->sortable()->searchable(),
            Column::make(__('Código del producto'), 'producto.codigo_producto')->sortable()->searchable(),
            Column::make(__('Categoria'), 'producto.categorias.nombre_categoria')->sortable()->searchable(),
            Column::make(__('Tipo de producto'), 'producto.tipoProducto.nombre_tipo_producto')->sortable()->searchable(),
            Column::make(__('Nombre del producto'), 'producto.descripcion')->sortable()->searchable(),
            Column::make(__('Tipo de impuesto'), 'producto.tipoImpuesto.descripcion')->sortable()->searchable(),
            Column::make(__('Unidad de medida'), 'producto.unidadMedida.nombre_unidad_medida')->sortable()->searchable(),
            Column::make(__('Costo Unitario'), 'producto.costo_unitario')->sortable()->searchable(),
            Column::make(__('Precio (con IVA)'), 'producto.precio_unitario_con_iva')->sortable()->searchable(),
            Column::make(__('Precio (sin IVA)'), 'producto.precio_unitario_sin_iva')->sortable()->searchable(),
            Column::make(__('Comisión'), 'producto.comision')->sortable()->searchable(),
            Column::make(__('Stock'), 'stock')->sortable()->searchable(),
            Column::make(__('Min Stock'), 'stock_minimo')->sortable()->searchable(),
            Column::make(__('Estado'), function (mixed $value): string {

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

    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }

    protected function canSelect(): bool
    {
        return false;
    }
}
