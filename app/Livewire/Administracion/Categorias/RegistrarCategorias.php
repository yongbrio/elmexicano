<?php

namespace App\Livewire\Administracion\Categorias;

use App\Models\CategoriasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarCategorias extends Component
{

    public $nombre_categoria;
    public $estado;

    public function render()
    {
        return view('livewire.administracion.categorias.registrar-categorias');
    }

    public function registrarCategoria()
    {

        // Normalizar el nombre de la categoría
        $nombreCategoria = $this->nombre_categoria;
        // Eliminar espacios adicionales y espacios al inicio y al final
        $nombreCategoria = trim(preg_replace('/\s+/', ' ', $nombreCategoria));

        // Convertir la primera letra de cada palabra a mayúscula y el resto a minúscula
        $nombreCategoria = ucwords(strtolower($nombreCategoria));

        $this->validacionCampos();

        $categoria = CategoriasModel::create([
            'nombre_categoria' => $nombreCategoria,
            'estado' => $this->estado,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($categoria) {
            $message = "La categoría ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
        } else {

        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria',
            'estado' => 'required|integer'
        ], [
            'nombre_categoria.required' => 'La categoría es requerida.',
            'nombre_categoria.unique' => 'La categoría ya existe.',
            'estado.required' => 'No asignó un estado.',
        ]);
    }
    
    #[On('resetInputs')]
    public function resetInputs()
    {
        // Restablecer los valores de las propiedades utilizadas en los campos de entrada
        $this->nombre_categoria = null;
        $this->estado = null; // Ajusta esto según el nombre real de tu propiedad
    }
}
