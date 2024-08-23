<?php

namespace App\Observers;

use App\Models\LogModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GenericObserver
{
    public function created(Model $model)
    {
        LogModel::create([
            'id_usuario' => Auth::user()->id,
            'nombre_usuario' => Auth::user()->username,
            'nombre_apellido' => Auth::user()->name . " - " . Auth::user()->apellidos,
            'action' => 'Creación',
            'model' => get_class($model),
            'model_id' => $model->id,
            'old_values' => '',
            'new_values' => json_encode($model->getAttributes()),
        ]);
    }

    public function updated(Model $model)
    {
        $oldValues = $model->getOriginal();
        $newValues = $model->getChanges();
        LogModel::create([
            'id_usuario' => Auth::user()->id,
            'nombre_usuario' => Auth::user()->username,
            'nombre_apellido' => Auth::user()->name . " - " . Auth::user()->apellidos,
            'action' => 'Actualización',
            'model' => get_class($model),
            'model_id' => $model->id,
            'old_values' => json_encode($oldValues), // Valores anteriores
            'new_values' => json_encode($newValues),  // Valores actuales
        ]);
    }

    public function deleted(Model $model)
    {
        LogModel::create([
            'id_usuario' => Auth::user()->id,
            'nombre_usuario' => Auth::user()->username,
            'nombre_apellido' => Auth::user()->name . " - " . Auth::user()->apellidos,
            'action' => 'Eliminación',
            'model' => get_class($model),
            'model_id' => $model->id,
            'old_values' => '',
            'new_values' => json_encode($model->getAttributes()),

        ]);
    }
}
