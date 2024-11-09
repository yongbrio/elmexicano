<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Administracion\AdminClientes;
use App\Livewire\Administracion\AprobarOrdenes\AdminAprobarOrdenes;
use App\Livewire\Administracion\Categorias\AdminCategorias;
use App\Livewire\Administracion\CuentasBancarias\AdminCuentasBancarias;
use App\Livewire\Administracion\CuentasBancarias\EditarCuentaBancaria;
use App\Livewire\Administracion\EditarCliente;
use App\Livewire\Administracion\Egresos\AdminEgresos;
use App\Livewire\Administracion\Egresos\EditarEgreso;
use App\Livewire\Administracion\Empresas\AdminEmpresas;
use App\Livewire\Administracion\Empresas\EditarEmpresa;
use App\Livewire\Administracion\Inventario\AdminInventario;
use App\Livewire\Administracion\Inventario\EditarInventario;
use App\Livewire\Administracion\Log\Log;
use App\Livewire\Administracion\Ordenes\AdminOrdenes;
use App\Livewire\Administracion\Perfiles\AdminPerfiles;
use App\Livewire\Administracion\Proveedores\AdminProveedores;
use App\Livewire\Administracion\Proveedores\EditarProveedor;
use App\Livewire\Administracion\Sucursales\AdminSucursales;
use App\Livewire\Administracion\Sucursales\EditarSucursal;
use App\Livewire\Administracion\Usuarios\AdminUsuarios;
use App\Livewire\Administracion\Usuarios\EditarUsuario;
use App\Livewire\Dashboard;
use App\Livewire\General\Caja\Caja;
use App\Livewire\General\Clientes\Clientes;
use App\Livewire\General\Egresos\Egresos;
use App\Livewire\General\Inventario\Inventario;
use App\Livewire\General\Ordenes\Egreso;
use App\Livewire\General\Ordenes\Ingreso;
use App\Livewire\General\Ordenes\Ordenes;
use App\Livewire\General\Proveedores\Proveedores;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
})->middleware(['guest']);

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Grupo de administración
Route::prefix('admin')->middleware(['auth'])->group(function () {
    /* Clientes */
    Route::get('/clientes', AdminClientes::class)->name('admin-clientes')->middleware('can:admin.clientes');
    Route::get('/clientes/{id}', EditarCliente::class)->name('editar-cliente')->middleware('can:admin.clientes');
    /* Empresas */
    Route::get('/empresas', AdminEmpresas::class)->name('admin-empresas')->middleware('can:admin.empresas');
    Route::get('/empresas/{id}', EditarEmpresa::class)->name('editar-empresa')->middleware('can:admin.empresas');
    /* Cuentas Bancarias */
    Route::get('/cuentas-bancarias', AdminCuentasBancarias::class)->name('admin-cuentas-bancarias')->middleware('can:admin.cuentas_bancarias');
    Route::get('/cuentas-bancarias/{id}', EditarCuentaBancaria::class)->name('editar-cuenta-bancaria')->middleware('can:admin.cuentas_bancarias');
    /* Sucursales */
    Route::get('/sucursales', AdminSucursales::class)->name('admin-sucursales')->middleware('can:admin.sucursales');
    Route::get('/sucursales/{id}', EditarSucursal::class)->name('editar-sucursal')->middleware('can:admin.sucursales');
    /* Proveedores */
    Route::get('/proveedores', AdminProveedores::class)->name('admin-proveedores')->middleware('can:admin.proveedores');
    Route::get('/proveedores/{id}', EditarProveedor::class)->name('editar-proveedor')->middleware('can:admin.proveedores');
    /* Categorías */
    Route::get('/categorias', AdminCategorias::class)->name('admin-categorias')->middleware('can:admin.categoria.productos');
    /* Inventario */
    Route::get('/inventario', AdminInventario::class)->name('admin-inventario')->middleware('can:admin.inventario');
    Route::get('/inventario/{id}', EditarInventario::class)->name('editar-inventario')->middleware('can:admin.inventario');
    /* Usuarios */
    Route::get('/usuarios', AdminUsuarios::class)->name('admin-usuarios')->middleware('can:seguridad.usuarios');
    Route::get('/usuarios/{id}', EditarUsuario::class)->name('editar-usuario')->middleware('can:seguridad.usuarios');
    /* Perfiles */
    Route::get('/perfiles', AdminPerfiles::class)->name('admin-perfiles')->middleware('can:seguridad.perfiles');
    /* Egresos */
    Route::get('/egresos', AdminEgresos::class)->name('admin-egresos')->middleware('can:admin.egresos');
    Route::get('/egresos/{id}', EditarEgreso::class)->name('editar-egreso')->middleware('can:admin.egresos');
    /* Ordenes */
    Route::get('/ordenes', AdminOrdenes::class)->name('admin-ordenes')->middleware('can:admin.ordenes');
    /* Aprobar Ordenes */
    Route::get('/aprobar-ordenes', AdminAprobarOrdenes::class)->name('admin-aprobar-ordenes')->middleware('can:admin.aprobar.ordenes');
    /* Acceso a imagenes */
    Route::get('/storage/{modulo}/{filename}', function ($modulo, $filename) {
        $fullPath = storage_path("app/imagenes/{$modulo}/{$filename}");
        if (!file_exists($fullPath)) {
            abort(404);
        }
        return response()->file($fullPath);
    })->name('admin.storage');

    /* Log de registros */
    Route::get('/log', Log::class)->name('admin-log')->middleware('can:seguridad.log');
});
//Grupo general
Route::prefix('general')->middleware(['auth'])->group(function () {
    /* Clientes */
    Route::get('/clientes', Clientes::class)->name('clientes-general')->middleware('can:clientes');
    /* Proveedores */
    Route::get('/proveedores', Proveedores::class)->name('proveedores-general')->middleware('can:proveedores');
    /* Inventario */
    Route::get('/inventario', Inventario::class)->name('inventario-general')->middleware('can:inventario');
    /* Egresos */
    Route::get('/egresos', Egresos::class)->name('egresos-general')->middleware('can:egresos');
    /* Ordenes Ingreso*/
    Route::get('/ingreso/{id}', Ingreso::class)->name('ordenes-ingreso')->middleware('can:clientes');
    /* Ordenes Egreso*/
    Route::get('/egreso/{id}', Egreso::class)->name('ordenes-egreso')->middleware('can:proveedores');
    /* Caja*/
    Route::get('/caja', Caja::class)->name('caja-general')->middleware('can:caja');
    /* Lista Ordenes*/
    /* Route::get('/ordenes', Ordenes::class)->name('ordenes')->middleware('can:ordenes'); */
});

require __DIR__ . '/auth.php';
