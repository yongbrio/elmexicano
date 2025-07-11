<?php

namespace App\Livewire\General\Ordenes;

use App\Models\CategoriasModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\TipoProductoModel;
use App\Models\UnidadesMedidaModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class ListaInventario extends LivewireTable
{
    protected string $model = InventarioModel::class;

    public $id_sucursal;

    public function mount(int $id_sucursal)
    {
        $this->id_sucursal = $id_sucursal;
    }

    /** @return Builder<Model> */
    protected function query(): Builder
    {
        $sucursal = SucursalesModel::find(Auth::user()->caja);
        if (strtolower($sucursal->nombre_sucursal) == 'corporativo') {


            $query = $this->model()->query()
                ->where('inventario.estado', '=', 1)
                ->where('inventario.sucursal_id', '=', $this->id_sucursal)
                ->whereHas('producto', function ($query) {
                    $query->where('tipo_producto', '<>', 1);
                })->with(['sucursal', 'registro', 'producto.categorias']);
            Log::info($query->toSql());
            Log::info($this->id_sucursal);

            return $query;
        } else {
            return $this->model()->query()
                ->where('inventario.estado', '=', 1)
                ->where('inventario.sucursal_id', '=', Auth::user()->caja)
                ->whereHas('producto', function ($query) {
                    $query->where('tipo_producto', '<>', 1);
                })
                ->with(['sucursal', 'registro', 'producto.categorias']);
        }
    }

    protected function columns(): array
    {
        return [
            Column::make(__('Agregar'), function ($value): string {
                return '<button type="button"  wire:click="agregar(' . $value->id . ')" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 ">
                    <i class="fa-solid fa-plus"></i>
                </button>';
            })->asHtml(),
            Column::make(__('Código'), 'producto.codigo_producto')->sortable()->searchable(),
            Column::make(__('Categoría'), 'producto.categorias.nombre_categoria')->sortable()->searchable(),
            Column::make(__('Nombre del producto'), 'producto.descripcion')->sortable()->searchable(),
            Column::make(__('Precio + IVA'), function ($value) {
                return "$" . number_format($value->producto->precio_unitario_con_iva, 0, ',', '.');
            })->sortable()->searchable(),
            Column::make(__('Stock'), 'stock')->sortable()->searchable(),
        ];
    }

    protected function canSelect(): bool
    {
        return false;
    }

    public function agregar($id)
    {
        $this->dispatch('agregar', id: $id);
    }

    #[On('recargarComponente')]
    public function recargarComponente()
    {
        $this->columns();
    }
}
