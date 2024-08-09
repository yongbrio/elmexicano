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
            'changes' => json_encode($model->getAttributes()),
        ]);
    }

    public function updated(Model $model)
    {
        LogModel::create([
            'id_usuario' => Auth::user()->id,
            'nombre_usuario' => Auth::user()->username,
            'nombre_apellido' => Auth::user()->name . " - " . Auth::user()->apellidos,
            'action' => 'Actualización',
            'model' => get_class($model),
            'model_id' => $model->id,
            'changes' => json_encode($model->getChanges()),
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
            'changes' => json_encode($model->getAttributes()),
        ]);
    }
}
