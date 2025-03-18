<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\LogModel;
use Illuminate\Database\Eloquent\Model;

class GenericObserver
{
    public function created(Model $model)
    {
        if (!Auth::check()) {
            return; // No hay usuario autenticado, no hacemos nada
        }

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
        if (!Auth::check()) {
            return;
        }

        $oldValues = $model->getOriginal();
        $newValues = $model->getChanges();

        LogModel::create([
            'id_usuario' => Auth::user()->id,
            'nombre_usuario' => Auth::user()->username,
            'nombre_apellido' => Auth::user()->name . " - " . Auth::user()->apellidos,
            'action' => 'Actualización',
            'model' => get_class($model),
            'model_id' => $model->id,
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
        ]);
    }

    public function deleted(Model $model)
    {
        if (!Auth::check()) {
            return;
        }

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
