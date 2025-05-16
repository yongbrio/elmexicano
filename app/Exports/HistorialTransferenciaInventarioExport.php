<?php

namespace App\Exports;

use App\Models\HistorialTransferenciasModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistorialTransferenciaInventarioExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    // Recibe las fechas como parámetros
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Consulta con rango de fechas
    public function query()
    {
        return HistorialTransferenciasModel::query()
            ->join('users', 'historial_transferencias.registrado_por', '=', 'users.id')
            ->whereBetween('historial_transferencias.created_at', [$this->startDate, $this->endDate])
            ->where('historial_transferencias.transferencia_recibida', '!=', 0)
            ->select('historial_transferencias.*', 'users.name', 'users.apellidos');
    }


    // Definir encabezados del Excel
    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'ID sucursal origen',
            'Nombre sucursal origen',
            'Código de producto',
            'Nombre producto',
            'Cantidad transferida',
            'Movimiento',
            'Estado de transferencia',
            'ID sucursal destino',
            'Nombre sucursal destino',
            'ID usuario registro',
            'Nombre usuario registro',
        ];
    }

    // Formatear datos en cada fila
    public function map($registro): array
    {
        $estado_aprobacion = "En tránsito";

        if ($registro->transferencia_recibida == 2) {
            $estado_aprobacion = "Recibida";
        } else if ($registro->transferencia_recibida == 3) {
            $estado_aprobacion = "Rechazado";
        } else if ($registro->transferencia_recibida == 4) {
            $estado_aprobacion = "Cancelado por el usuario";
        }

        $movimiento = "Entrada";
        if ($registro->id_sucursal_origen == Auth::user()->caja) {
            $movimiento = "Salida";
        }

        return [
            $registro->id,
            $registro->created_at->format('d/m/Y'),
            $registro->id_sucursal_origen,
            $registro->nombre_sucursal_origen,
            $registro->codigo_producto,
            $registro->nombre_producto,
            $registro->cantidad_transferida,
            $movimiento,
            $estado_aprobacion,
            $registro->id_sucursal_destino,
            $registro->nombre_sucursal_destino,
            $registro->registrado_por,
            $registro->name . " " . $registro->apellidos,
        ];
    }
}
