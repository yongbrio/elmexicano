<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Administracion\AdminClientes;
use App\Livewire\Administracion\CuentasBancarias\AdminCuentasBancarias;
use App\Livewire\Administracion\CuentasBancarias\EditarCuentaBancaria;
use App\Livewire\Administracion\EditarCliente;
use App\Livewire\Administracion\Empresas\AdminEmpresas;
use App\Livewire\Administracion\Empresas\EditarEmpresa;
use App\Livewire\Administracion\Proveedores\AdminProveedores;
use App\Livewire\Administracion\Proveedores\EditarProveedor;
use App\Livewire\Administracion\Sucursales\AdminSucursales;
use App\Livewire\Administracion\Sucursales\EditarSucursal;
use App\Livewire\Dashboard;
use App\Livewire\General\Clientes\Clientes;
use App\Livewire\General\Proveedores\Proveedores;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
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
    Route::get('/clientes', AdminClientes::class)->name('admin-clientes');
    Route::get('/clientes/{id}', EditarCliente::class)->name('editar-cliente');
    /* Empresas */
    Route::get('/empresas', AdminEmpresas::class)->name('admin-empresas');
    Route::get('/empresas/{id}', EditarEmpresa::class)->name('editar-empresa');
    /* Cuentas Bancarias */
    Route::get('/cuentas-bancarias', AdminCuentasBancarias::class)->name('admin-cuentas-bancarias');
    Route::get('/cuentas-bancarias/{id}', EditarCuentaBancaria::class)->name('editar-cuenta-bancaria');
    /* Sucursales */
    Route::get('/sucursales', AdminSucursales::class)->name('admin-sucursales');
    Route::get('/sucursales/{id}', EditarSucursal::class)->name('editar-sucursal');
    /* Proveedores */
    Route::get('/proveedores', AdminProveedores::class)->name('admin-proveedores');
    Route::get('/proveedores/{id}', EditarProveedor::class)->name('editar-proveedor');
});
//Grupo general
Route::prefix('general')->middleware(['auth'])->group(function () {
    /* Clientes */
    Route::get('/clientes', Clientes::class)->name('clientes-general');
    Route::get('/proveedores', Proveedores::class)->name('proveedores-general');
});

require __DIR__ . '/auth.php';
