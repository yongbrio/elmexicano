<?php

namespace App\Livewire\Administracion\Perfiles;

use App\Models\PerfilesModel;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class AdminPerfiles extends Component
{

    public $perfil;
    public $nombre_perfil_edit;
    public $estado_edit;
    public $id_perfil;
    public $role_id;
    public $modulosArray = [];
    public function render()
    {
        return view('livewire.administracion.perfiles.admin-perfiles');
    }


    #[On('setearPerfil')]
    public function setearPerfil($id)
    {
        $perfil = PerfilesModel::join('roles', 'perfiles.id_rol', '=', 'roles.id')
            ->select('perfiles.*', 'roles.name as role_name', 'roles.id as role_id')
            ->where('perfiles.id', $id)->first();

        $this->perfil = $perfil;
        $this->nombre_perfil_edit = $perfil->role_name;
        $this->estado_edit = $perfil->estado;
        $this->id_perfil = $perfil->id;
        $this->role_id = $perfil->role_id;

    }

    public function editarPerfil()
    {
        $this->validacionCampos();

        $role = Role::find($this->role_id);

        $role->name = $this->formatearTexto($this->nombre_perfil_edit);

        $updateRole = $role->save();

        $this->perfil->estado = $this->estado_edit;

        $perfil = $this->perfil->save();

        if ($perfil && $updateRole) {

            $message = "El Perfil se ha actualizado correctamente";
            $this->dispatch('estadoActualizacionPerfil', title: "Actualizado", icon: 'success', message: $message);
            $this->dispatch('recargarComponente');

            $this->nombre_perfil_edit = NULL;
            $this->estado_edit = NULL;
            $this->perfil = NULL;
            $this->role_id = NULL;
        }
    }

    private function formatearTexto($input)
    {
        // Elimina espacios al inicio y al final
        $trimmed = trim($input);

        // Reemplaza múltiples espacios en blanco por un solo espacio
        $singleSpaced = preg_replace('/\s+/', ' ', $trimmed);

        // Convierte la primera letra de cada palabra a mayúscula y el resto a minúscula
        $capitalized = mb_convert_case($singleSpaced, MB_CASE_TITLE, "UTF-8");

        return $capitalized;
    }

    public function cerrarModalEditarPerfil()
    {
        $this->nombre_perfil_edit = NULL;
        $this->estado_edit = NULL;
        $this->perfil =  NULL;
        $this->role_id =  NULL;
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombre_perfil_edit' => 'required|string|max:255|unique:roles,name,' . $this->role_id,
            'estado_edit' => 'required|integer'
        ], [
            'nombre_perfil_edit.required' => 'El perfil es requerido.',
            'nombre_perfil_edit.unique' => 'El perfil ya existe.',
            'estado_edit.required' => 'No asignó un estado.',
        ]);
    }
}
