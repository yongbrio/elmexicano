<?php

namespace App\Livewire\Administracion\Inventario;

use App\Models\CategoriasModel;
use App\Models\InventarioModel;
use App\Models\SucursalesModel;
use Illuminate\Database\Eloquent\Builder;
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
        return $this->model()->query()->with(['sucursal', 'registro', 'producto.categorias']);
    }

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="editarInventario(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('Imagen'), function ($value) {
                if ($value->producto->imagen != '') {
                    $path = $value->producto->imagen;
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
            Column::make(__('Comisiona'), function ($value) {
                if (is_null($value->comisiona)) {
                    return 'No seleccionó';
                }
                return $value->comisiona ? 'Sí' : 'No';
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
