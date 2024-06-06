<?php

namespace App\Livewire\Administracion\Perfiles;

use App\Models\PerfilesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegistrarPerfiles extends Component
{

    public $nombre_perfil;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.perfiles.registrar-perfiles');
    }

    public function registrarPerfil()
    {

        // Normalizar el nombre del perfil
        $nombrePerfil = $this->nombre_perfil;
        // Eliminar espacios adicionales y espacios al inicio y al final
        $nombrePerfil = trim(preg_replace('/\s+/', ' ', $nombrePerfil));

        // Convertir la primera letra de cada palabra a mayúscula y el resto a minúscula
        $nombrePerfil = ucwords(strtolower($nombrePerfil));

        $this->validacionCampos();

        $role = Role::create(['name' => $nombrePerfil]);

        $perfil = PerfilesModel::create([
            'id_rol' => $role->id,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($perfil && $role) {
            $message = "El perfil ha sido creado con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {
            $message = "El perfil NO ha sido creado con éxito";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombre_perfil' => 'required|string|max:255|unique:roles,name',
            'estado' => 'required|integer'
        ], [
            'nombre_perfil.required' => 'El perfil es requerido.',
            'nombre_perfil.unique' => 'El perfil ya existe.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }
    
    #[On('resetInputs')]
    public function resetInputs()
    {
        // Restablecer los valores de las propiedades utilizadas en los campos de entrada
        $this->nombre_perfil = null;
        $this->estado = null; // Ajusta esto según el nombre real de tu propiedad
    }
}
