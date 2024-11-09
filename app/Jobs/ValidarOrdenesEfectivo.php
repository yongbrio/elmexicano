<?php

namespace App\Jobs;

use App\Models\OrdenesModel;
use App\Models\PagosOrdenes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ValidarOrdenesEfectivo
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $datos_ordenes = OrdenesModel::where('estado_orden', 1)->where('forma_pago', 'efectivo')->get();

        foreach ($datos_ordenes as $orden) {

            OrdenesModel::withoutEvents(function () use ($orden) {
                $orden->estado_orden = 2;
                $orden->estado_pago = 'validado';
                $orden->save();
            });

            $pagos_ordenes = PagosOrdenes::where('orden', $orden->id)->first();
            PagosOrdenes::withoutEvents(function () use ($pagos_ordenes) {
                $pagos_ordenes->id_estado_pago = 2;
                $pagos_ordenes->nombre_estado_pago = 'validado';
                $pagos_ordenes->save();
            });
        }
    }
}
