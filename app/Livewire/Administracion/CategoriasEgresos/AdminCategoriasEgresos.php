<?php

namespace App\Livewire\Administracion\CategoriasEgresos;

use App\Models\CategoriasEgresosAsociadasModel;
use App\Models\EgresosModel;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminCategoriasEgresos extends Component
{
    public function render()
    {
        return view('livewire.administracion.categorias-egresos.admin-categorias-egresos');
    }

    #[On('eliminarCategoriaAsociada')]
    public function eliminarCategoriaAsociada($id)
    {
        $categoria = CategoriasEgresosAsociadasModel::find($id);

        if ($categoria) {

            $categoria_1 = $categoria->id_categoria_1;
            $categoria_2 = $categoria->id_categoria_2;

            $egreso = EgresosModel::where('categoria_1', $categoria_1)->where('categoria_2', $categoria_2)->first();

            if ($egreso) {
                $message = "La categoría está asociada a un egreso. No se puede eliminar. Puede desactivarla.";
                $this->dispatch('estadoActualizacionCategoriaAsociada', title: "Error", icon: 'error', message: $message);
            } else {
                $categoria->delete();
                $message = "La categoría se ha eliminado con éxito";
                $this->dispatch('estadoActualizacionCategoriaAsociada', title: "Eliminado", icon: 'success', message: $message);
            }
        }
    }
}
