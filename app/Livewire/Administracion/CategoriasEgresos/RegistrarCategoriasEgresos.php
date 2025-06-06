<?php

namespace App\Livewire\Administracion\CategoriasEgresos;

use App\Models\CategoriasEgresos1Model;
use App\Models\CategoriasEgresos2Model;
use App\Models\CategoriasEgresosAsociadasModel;
use App\Models\EgresosModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarCategoriasEgresos extends Component
{
    public $categoria_1;
    public $categoria_2;
    public $lista_categorias_1;
    public $lista_categorias_2;

    public function render()
    {
        return view('livewire.administracion.categorias-egresos.registrar-categorias-egresos');
    }

    public function RegistrarCategoria1()
    {
        // Normalizar el nombre de la categoría
        $nombreCategoria = $this->categoria_1;
        // Eliminar espacios adicionales y espacios al inicio y al final
        $nombreCategoria = trim(preg_replace('/\s+/', ' ', $nombreCategoria));
        //Convertir a mayuscula
        $nombreCategoria = strtoupper($nombreCategoria);

        $this->validacionCamposCategoria1();

        $categoria1 = CategoriasEgresos1Model::create([
            'nombre_categoria' => $nombreCategoria,
            'estado' => 1,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($categoria1) {
            $message = "La categoría 1 ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
            $this->categoria_1 = '';
            $this->dispatch('recargarComponente');
        }
    }

    public function RegistrarCategoria2()
    {
        // Normalizar el nombre de la categoría
        $nombreCategoria = $this->categoria_2;
        // Eliminar espacios adicionales y espacios al inicio y al final
        $nombreCategoria = trim(preg_replace('/\s+/', ' ', $nombreCategoria));
        //Convertir a mayuscula
        $nombreCategoria = strtoupper($nombreCategoria);

        $this->validacionCamposCategoria2();

        $categoria2 = CategoriasEgresos2Model::create([
            'nombre_categoria' => $nombreCategoria,
            'estado' => 1,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($categoria2) {
            $message = "La categoría 2 ha sido creada con éxito";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
            $this->categoria_2 = '';
            $this->dispatch('recargarComponente');
        }
    }

    public function validacionCamposCategoria1()
    {
        return  $this->validate([
            'categoria_1' => 'required|string|max:255|unique:categorias_egresos1,nombre_categoria',
        ], [
            'categoria_1.required' => 'La categoría es requerida.',
            'categoria_1.unique' => 'La categoría ya existe.',
        ]);
    }

    public function validacionCamposCategoria2()
    {
        return  $this->validate([
            'categoria_2' => 'required|string|max:255|unique:categorias_egresos2,nombre_categoria',
        ], [
            'categoria_2.required' => 'La categoría es requerida.',
            'categoria_2.unique' => 'La categoría ya existe.',
        ]);
    }

    #[On('recargarCategoria1')]
    public function recargarCategoria1()
    {
        $this->lista_categorias_1 = "";
    }

    #[On('recargarCategoria2')]
    public function recargarCategoria2()
    {
        $this->lista_categorias_2 = "";
    }

    public function validarAsociacionCategorias()
    {
        // Validar que los campos sean obligatorios y numéricos
        $datos = $this->validate([
            'lista_categorias_1' => 'required',
            'lista_categorias_2' => 'required',
        ], [
            'lista_categorias_1.required' => 'La primera categoría es obligatoria.',
            'lista_categorias_2.required' => 'La segunda categoría es obligatoria.',
        ]);

        // Comprobar si la relación ya existe en la base de datos
        $existeRelacion = DB::table('categorias_egresos_asociadas')
            ->where('id_categoria_1', $datos['lista_categorias_1'])
            ->where('id_categoria_2', $datos['lista_categorias_2'])
            ->exists();

        if ($existeRelacion) {
            throw ValidationException::withMessages([
                'lista_categorias_1' => 'Esta asociación de categorías ya existe.',
                'lista_categorias_2' => 'Esta asociación de categorías ya existe.',
            ]);
        }
    }

    public function asociarCategorias()
    {
        $this->validarAsociacionCategorias();

        $asociacion = CategoriasEgresosAsociadasModel::create([
            'id_categoria_1' => $this->lista_categorias_1,
            'id_categoria_2' => $this->lista_categorias_2,
            'estado' => 1,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($asociacion) {
            $message = "Las categorías se han asociado correctamente";
            $this->dispatch('estadoActualizacion', title: "Creado", icon: 'success', message: $message);
            $this->recargarCategoria1();
            $this->recargarCategoria2();
            $this->dispatch('recargarComponenteListaCategoriasAsociadas');
        }
    }

    #[On('eliminarCategoria1')]
    public function eliminarCategoriaAsociada1($id)
    {
        $egreso = EgresosModel::where('categoria_1', $id)->first();
        $categoria_asociada = CategoriasEgresosAsociadasModel::where('id_categoria_1', $id)->first();

        if ($egreso) {
            $message = "La categoría 1 está asociada a un egreso. No se puede eliminar.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        } else if ($categoria_asociada) {
            $message = "La categoría 1 está asociada con una categoría 2. No se puede eliminar. Intente el,iminar la asociación.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        } else {
            $categoria = CategoriasEgresos1Model::find($id);
            $categoria->delete();
            $message = "La categoría 1 ha sido eliminada con éxito.";
            $this->dispatch('estadoActualizacion', title: "Eliminado", icon: 'success', message: $message);
        }
    }

    #[On('eliminarCategoria2')]
    public function eliminarCategoriaAsociada2($id)
    {
        $egreso = EgresosModel::where('categoria_2', $id)->first();
        $categoria_asociada = CategoriasEgresosAsociadasModel::where('id_categoria_2', $id)->first();

        if ($egreso) {
            $message = "La categoría 2 está asociada a un egreso. No se puede eliminar.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        } else if ($categoria_asociada) {
            $message = "La categoría 2 está asociada con una categoría 1. No se puede eliminar. Intente el,iminar la asociación.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        } else {
            $categoria = CategoriasEgresos2Model::find($id);
            $categoria->delete();
            $message = "La categoría 2 ha sido eliminada con éxito.";
            $this->dispatch('estadoActualizacion', title: "Eliminado", icon: 'success', message: $message);
        }
    }
}
