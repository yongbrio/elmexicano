<?php

namespace App\Livewire\Administracion\Categorias;

use App\Models\CategoriasModel;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminCategorias extends Component
{
    public $id_categoria;
    public $categoria;
    public $nombre_categoria_edit;
    public $estado_edit;

    public function render()
    {
        return view('livewire.administracion.categorias.admin-categorias');
    }

    #[On('setearCategoria')]
    public function setearCategoria($id)
    {
        $categoria = CategoriasModel::find($id);
        $this->categoria = $categoria;
        $this->nombre_categoria_edit = $categoria->nombre_categoria;
        $this->estado_edit = $categoria->estado;
        $this->id_categoria = $categoria->id;
    }

    public function editarCategoria()
    {
        $this->validacionCampos();

        $this->categoria->nombre_categoria = $this->formatearTexto($this->nombre_categoria_edit);
        $this->categoria->estado = $this->estado_edit;
        $categoria = $this->categoria->save();

        if ($categoria) {

            $message = "La categoría se ha actualizado con éxito";
            $this->dispatch('estadoActualizacionCategoria', title: "Actualizado", icon: 'success', message: $message);
            $this->dispatch('recargarComponente');

            $this->nombre_categoria_edit = NULL;
            $this->estado_edit = NULL;
            $this->categoria =  NULL;
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

    public function cerrarModalEditarCategoria()
    {
        $this->nombre_categoria_edit = NULL;
        $this->estado_edit = NULL;
        $this->categoria =  NULL;
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'nombre_categoria_edit' => 'required|string|max:255|unique:categorias,nombre_categoria,' . $this->id_categoria,
            'estado_edit' => 'required|integer'
        ], [
            'nombre_categoria_edit.required' => 'La categoría es requerida.',
            'nombre_categoria_edit.unique' => 'La categoría ya existe.',
            'estado_edit.required' => 'No asignó un estado.',
        ]);
    }
}
