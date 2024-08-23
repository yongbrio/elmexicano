<?php

namespace App\Livewire\Administracion\Perfiles;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AsignarPermisos extends Component
{
    public $modulosArrayGenerales = [];
    public $modulosArrayAdministracion = [];
    public $modulosArraySeguridad = [];
    public $role_id = [];

    public function render()
    {
        return view('livewire.administracion.perfiles.asignar-permisos');
    }

    #[On('asignarPermisosRol')]
    public function asignarPermisosRol($role_id)
    {
        $this->role_id = $role_id;

        $this->reiniciarArrays();

        $this->modulosArrayGenerales = [
            ['nombre_modulo' => 'Caja', 'id' => 'caja' . $this->role_id, 'name_permission' => 'caja', 'activate' => $this->validarSiPermisoExiste("caja")],
            ['nombre_modulo' => 'Clientes', 'id' => 'clientes' . $this->role_id, 'name_permission' => 'clientes', 'activate' => $this->validarSiPermisoExiste("clientes")],
            ['nombre_modulo' => 'Proveedores', 'id' => 'proveedores' . $this->role_id, 'name_permission' => 'proveedores', 'activate' => $this->validarSiPermisoExiste("proveedores")],
            ['nombre_modulo' => 'Inventario', 'id' => 'inventario' . $this->role_id, 'name_permission' => 'inventario', 'activate' => $this->validarSiPermisoExiste("inventario")],
            ['nombre_modulo' => 'Egresos', 'id' => 'egresos' . $this->role_id, 'name_permission' => 'egresos', 'activate' => $this->validarSiPermisoExiste("egresos")],
            /*             ['nombre_modulo' => 'Ordenes Ingreso', 'id' => 'ordenes_ingreso' . $this->role_id, 'name_permission' => 'ordenes_ingreso', 'activate' => $this->validarSiPermisoExiste("ordenes_ingreso")],
            ['nombre_modulo' => 'Ordenes Egreso', 'id' => 'ordenes_egreso' . $this->role_id, 'name_permission' => 'ordenes_egreso', 'activate' => $this->validarSiPermisoExiste("ordenes_egreso")], */
        ];

        $this->modulosArrayAdministracion = [
            ['nombre_modulo' => 'Admin Clientes', 'id' => 'admin_clientes' . $this->role_id, 'name_permission' => 'admin.clientes', 'activate' => $this->validarSiPermisoExiste("admin.clientes")],
            ['nombre_modulo' => 'Admin Proveedores', 'id' => 'admin_proveedores' . $this->role_id, 'name_permission' => 'admin.proveedores', 'activate' => $this->validarSiPermisoExiste("admin.proveedores")],
            ['nombre_modulo' => 'Empresas', 'id' => 'admin_empresas' . $this->role_id, 'name_permission' => 'admin.empresas', 'activate' => $this->validarSiPermisoExiste("admin.empresas")],
            ['nombre_modulo' => 'Sucursales', 'id' => 'admin_sucursales' . $this->role_id, 'name_permission' => 'admin.sucursales', 'activate' => $this->validarSiPermisoExiste("admin.sucursales")],
            ['nombre_modulo' => 'Cuentas Bancarias', 'id' => 'cuentas_bancarias' . $this->role_id, 'name_permission' => 'admin.cuentas_bancarias', 'activate' => $this->validarSiPermisoExiste("admin.cuentas_bancarias")],
            ['nombre_modulo' => 'Admin Inventario', 'id' => 'admin_inventario' . $this->role_id, 'name_permission' => 'admin.inventario', 'activate' => $this->validarSiPermisoExiste("admin.inventario")],
            ['nombre_modulo' => 'Categoría Productos', 'id' => 'admin_categoria_productos' . $this->role_id, 'name_permission' => 'admin.categoria.productos', 'activate' => $this->validarSiPermisoExiste("admin.categoria.productos")],
            ['nombre_modulo' => 'Admin Egresos', 'id' => 'admin_egresos' . $this->role_id, 'name_permission' => 'admin.egresos', 'activate' => $this->validarSiPermisoExiste("admin.egresos")],
            ['nombre_modulo' => 'Admin Ordenes', 'id' => 'admin_ordenes' . $this->role_id, 'name_permission' => 'admin.ordenes', 'activate' => $this->validarSiPermisoExiste("admin.ordenes")],

        ];

        $this->modulosArraySeguridad = [
            ['nombre_modulo' => 'Usuarios', 'id' => 'seguridad_usuarios' . $this->role_id, 'name_permission' => 'seguridad.usuarios', 'activate' => $this->validarSiPermisoExiste("seguridad.usuarios")],
            ['nombre_modulo' => 'Perfiles', 'id' => 'seguridad_perfiles' . $this->role_id, 'name_permission' => 'seguridad.perfiles', 'activate' => $this->validarSiPermisoExiste("seguridad.perfiles")],
            ['nombre_modulo' => 'Log', 'id' => 'seguridad_log' . $this->role_id, 'name_permission' => 'seguridad.log', 'activate' => $this->validarSiPermisoExiste("seguridad.log")],
        ];
    }

    private function reiniciarArrays()
    {
        $this->modulosArrayGenerales = [];
        $this->modulosArrayAdministracion = [];
        $this->modulosArraySeguridad = [];
    }

    private function validarSiPermisoExiste($name_permission)
    {
        // Encuentra el permiso por nombre
        $permission = Permission::where('name', "$name_permission")->first();
        // Verifica si el permiso existe
        if (!$permission) {
            return false;
        }

        // Encuentra el rol por su ID
        $role = Role::find($this->role_id);

        // Verifica si el rol existe
        if (!$role) {
            return false;
        }

        // Verifica si el rol ya tiene el permiso
        return $role->hasPermissionTo($permission);
    }

    public function cambiarPermiso($name_permiso)
    {
        // Encuentra o crea el permiso
        $permission = Permission::firstOrCreate(['name' => "$name_permiso"]);

        // Encuentra el rol por su ID
        $role = Role::find($this->role_id);

        // Verifica si el rol ya tiene el permiso
        if ($role->hasPermissionTo($permission)) {
            // Si el rol ya tiene el permiso, revócalo
            $role->revokePermissionTo($permission);
        } else {
            // Si el rol no tiene el permiso, asígnalo
            $role->givePermissionTo($permission);
        }
    }
}
