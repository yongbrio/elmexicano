<?php

namespace App\Providers;

use App\Models\CategoriasModel;
use App\Models\ClientesModel;
use App\Models\CuentasBancariasModel;
use App\Models\DepartamentosModel;
use App\Models\EgresosModel;
use App\Models\EmpresasModel;
use App\Models\HistorialTransferenciasModel;
use App\Models\InventarioModel;
use App\Models\MunicipiosModel;
use App\Models\OrdenesModel;
use App\Models\PerfilesModel;
use App\Models\ProveedoresModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\TipoProductoModel;
use App\Models\UnidadesMedidaModel;
use App\Models\User;
use App\Observers\GenericObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ClientesModel::observe(GenericObserver::class);
        CategoriasModel::observe(GenericObserver::class);
        CuentasBancariasModel::observe(GenericObserver::class);
        DepartamentosModel::observe(GenericObserver::class);
        EgresosModel::observe(GenericObserver::class);
        EmpresasModel::observe(GenericObserver::class);
        HistorialTransferenciasModel::observe(GenericObserver::class);
        InventarioModel::observe(GenericObserver::class);
        MunicipiosModel::observe(GenericObserver::class);
        OrdenesModel::observe(GenericObserver::class);
        PerfilesModel::observe(GenericObserver::class);
        ProveedoresModel::observe(GenericObserver::class);
        SucursalesModel::observe(GenericObserver::class);
        TipoAfectacionImpuestoModel::observe(GenericObserver::class);
        TipoProductoModel::observe(GenericObserver::class);
        UnidadesMedidaModel::observe(GenericObserver::class);
        User::observe(GenericObserver::class);
    }
}
