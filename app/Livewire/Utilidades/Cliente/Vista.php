<?php

namespace App\Livewire\Utilidades\Cliente;

use App\Models\ClientesModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use Livewire\Component;

class Vista extends Component
{
    public $id;
    public $nombreComercial;
    public $nombreLegal;
    public $grupo;
    public $telefono;
    public $nit;
    public $departamento;
    public $ciudad;
    public $direccion;
    public $barrio_localidad;
    public $sucursal;
    public $correo;
    public $nombreEncargado;
    public $descripcion;
    public $empresaFactura;
    public $importancia;
    public $iddepartamento;
    public $idciudad;
    public $listaMunicipios;

    public function mount($id)
    {
        $this->id = $id;

        $cliente = ClientesModel::find($this->id);

        if ($cliente) {

            $this->nombreComercial = $cliente->nombre_comercial;
            $this->nombreLegal = $cliente->nombre_legal;
            $this->grupo = $cliente->grupo;
            $this->telefono = $cliente->telefono;
            $this->nit = $cliente->nit;
            $this->sucursal = $cliente->sucursal;
            $this->direccion = $cliente->direccion;
            $this->barrio_localidad = $cliente->barrio_localidad;

            $nombre_municipio = MunicipiosModel::where('id', $cliente->ciudad)->first();
            $nombre_departamento = DepartamentosModel::where('id', $cliente->departamento)->first();

            $this->ciudad = $nombre_municipio->nombre_municipio;
            $this->departamento = $nombre_departamento->nombre_departamento;

            $this->iddepartamento = $cliente->departamento;
            $this->idciudad = $cliente->ciudad;
            $this->correo = $cliente->correo;
            $this->nombreEncargado = $cliente->nombre_encargado;
            $this->descripcion = $cliente->descripcion;
            $this->empresaFactura = $cliente->empresa_factura;
            $this->importancia = $cliente->importancia;
        }
    }

    public function render()
    {
        return view('livewire.utilidades.cliente.vista');
    }
}
