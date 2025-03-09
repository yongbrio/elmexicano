<?php

namespace App\Livewire\Administracion\Sucursales;

use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use App\Models\SucursalesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarSucursal extends Component
{
    public $id;
    public $identificador;
    public $nombre_sucursal;
    public $direccion;
    public $ciudad;
    public $idciudad;
    public $departamento;
    public $iddepartamento;
    public $barrio_localidad;
    public $giro_sucursal;
    public $tipo_sucursal;
    public $listaMunicipios;
    public $estado;

    public function mount($id)
    {
        $this->id = $id;

        $sucursal = SucursalesModel::find($this->id);

        if ($sucursal) {

            $nombre_municipio = MunicipiosModel::where('id', $sucursal->ciudad)->first();
            $nombre_departamento = DepartamentosModel::where('id', $sucursal->departamento)->first();

            $this->identificador = $sucursal->identificador;
            $this->nombre_sucursal = $sucursal->nombre_sucursal;
            $this->direccion  = $sucursal->direccion;
            $this->iddepartamento = $nombre_departamento->id;
            $this->departamento = $nombre_departamento->nombre_departamento;
            $this->idciudad = $nombre_municipio->id;
            $this->ciudad = $nombre_municipio->nombre_municipio;
            $this->barrio_localidad = $sucursal->barrio_localidad;
            $this->giro_sucursal = $sucursal->giro_sucursal_id;
            $this->tipo_sucursal = $sucursal->tipo_sucursal_id;
            $this->estado = $sucursal->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.sucursales.editar-sucursal');
    }

    public function actualizarSucursal()
    {
        $this->validacionCampos();

        $sucursal = SucursalesModel::find($this->id);

        if ($sucursal) {

            $sucursal->identificador = $this->identificador;
            $sucursal->nombre_sucursal = $this->nombre_sucursal;
            $sucursal->direccion = $this->direccion;
            $sucursal->departamento = $this->iddepartamento;
            $sucursal->ciudad = $this->idciudad;
            $sucursal->barrio_localidad = $this->barrio_localidad;
            $sucursal->giro_sucursal_id = $this->giro_sucursal;
            $sucursal->tipo_sucursal_id = $this->tipo_sucursal;
            $sucursal->estado = $this->estado;

            $actualizado = $sucursal->save();

            if ($actualizado) {
                $message = "La sucursal ha sido actualizada con éxito";
                $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
            } else {
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'identificador' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sucursales')->ignore($this->id)->where(function ($query) {
                    return $query->where('identificador', strtoupper($this->identificador));
                }),
            ],
            'nombre_sucursal' => 'required|string|max:255',
            'giro_sucursal' => 'required|string',
            'tipo_sucursal' => 'required|string',
            'barrio_localidad' => 'required|string|max:255',
            'departamento' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|integer'
        ], [
            'identificador.required' => 'El identificador es obligatorio.',
            'identificador.unique' => 'El identificador ya existe.',
            'nombre_sucursal.required' => 'La sucursal es obligatoria.',
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'giro_sucursal.required' => 'El giro de sucursal es requerido',
            'tipo_sucursal.required' => 'El tipo de sucursal es requerido',
            'barrio_localidad.required' => 'El barrio/localidad es requerido',
            'estado.required' => 'No asignó un estado.',
        ]);
    }

    public function cancelarActualizarSucursal()
    {
        return redirect()->route('admin-sucursales');
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-sucursales');
    }

    public function buscarCiudad()
    {
        if (!empty(trim($this->ciudad))) {

            $this->listaMunicipios = MunicipiosModel::where('nombre_municipio', 'like', '%' . $this->ciudad . '%')
                ->orderBy('nombre_municipio')
                ->take(5)
                ->get();

            $this->idciudad = null;
            $this->departamento = null;
            $this->iddepartamento = null;
        } else {

            $this->listaMunicipios = null;
            $this->iddepartamento = null;
            $this->departamento = null;
            $this->idciudad = null;
        }
    }

    public function setearNombreCiudad($id)
    {
        $this->listaMunicipios = null;

        $nombreCiudad = MunicipiosModel::find($id);

        if ($nombreCiudad) {
            $this->ciudad = $nombreCiudad->nombre_municipio;
            $this->idciudad = $id;
            $departamento = DepartamentosModel::where('codigo_dane', $nombreCiudad->codigo_departamento)->first();
            $this->departamento = $departamento->nombre_departamento;
            $this->iddepartamento = $departamento->id;
        }
    }
}
