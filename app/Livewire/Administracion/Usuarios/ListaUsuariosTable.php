<?php

namespace App\Livewire\Administracion\Usuarios;

use App\Models\CategoriasModel;
use App\Models\SucursalesModel;
use App\Models\TipoProductoModel;
use App\Models\User;
use Livewire\Component;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use Spatie\Permission\Models\Role;

class ListaUsuariosTable extends LivewireTable
{
    protected string $model = User::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Acciones'), function (mixed $value): string {
                return '<button type="button" wire:click="editarUsuario(' . $value->id . ')" class="px-3 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-pen-to-square"></i></button>';
            })->asHtml(),
            Column::make(__('Imagen'), function ($value) {
                if ($value->imagen != '') {
                    $path = $value->imagen;
                    $moduleName = 'usuarios'; // Nombre del módulo
                    $imageName = basename($path);
                    // Clases de Tailwind para hover y transición
                    return '<img class="w-10 h-10 transition duration-300 ease-in-out transform rounded-full cursor-pointer hover:scale-110" src="' . route("admin.storage", ["modulo" => $moduleName, "filename" => $imageName]) . '" alt="image description">';
                } else {
                    return '<img class="w-10 h-10 transition duration-300 ease-in-out transform rounded-full cursor-pointer hover:scale-110" src="' . asset('images/imagen-defecto-producto.jpg') . '" alt="image description">';
                }
            })->asHtml(),

            Column::make(__('Cédula'), 'cedula')->sortable()->searchable(),
            Column::make(__('Nombres'), 'name')->sortable()->searchable(),
            Column::make(__('Apellidos'), 'apellidos')->sortable()->searchable(),
            Column::make(__('Usuario de sistema'), 'username')->sortable()->searchable(),
            Column::make(__('Fecha de nacimiento'), 'fecha_nacimiento')->sortable()->searchable(),
            Column::make(__('Dirección'), 'direccion')->sortable()->searchable(),
            Column::make(__('Teléfono'), 'telefono')->sortable()->searchable(),
            Column::make(__('Correo'), 'correo')->sortable()->searchable(),
            Column::make(__('Fecha de Inicio'), 'fecha_inicio')->sortable()->searchable(),
            Column::make(__('Referencia 1'), 'referencia_1')->sortable()->searchable(),
            Column::make(__('Referencia 2'), 'referencia_2')->sortable()->searchable(),
            Column::make(__('Horario'), 'horario')->sortable()->searchable(),
            Column::make(__('EPS'), 'eps')->sortable()->searchable(),
            Column::make(__('Pensión'), 'pension')->sortable()->searchable(),
            Column::make(__('Banco'), 'banco')->sortable()->searchable(),
            Column::make(__('Número de cuenta'), 'numero_cuenta')->sortable()->searchable(),
            Column::make(__('Cargo'), 'cargo')->sortable()->searchable(),
            Column::make(__('Perfil'), function (mixed $value) {
                $role = Role::find($value->perfil);
                return $role->name;
            })->sortable()->searchable(),
            Column::make(__('Sucursal'),  function (mixed $value) {
                $sucursal = SucursalesModel::find($value->caja);
                return $sucursal->nombre_sucursal;
            })->sortable()->searchable(),
            Column::make(__('Nombre contacto emergencia'), 'nombre_contacto_emergencia')->sortable()->searchable(),
            Column::make(__('Número contacto emergencia'), 'numero_contacto_emergencia')->sortable()->searchable(),

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

    public function editarUsuario($id)
    {
        return redirect()->route('editar-usuario', ['id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        if ($estado == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $usuario = User::find($id);
        $usuario->estado = $estado;
        $usuario->save();
    }
}
