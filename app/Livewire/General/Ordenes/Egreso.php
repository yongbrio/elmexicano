<?php

namespace App\Livewire\General\Ordenes;

use App\Models\DepartamentosModel;
use App\Models\EgresosModel;
use App\Models\InventarioModel;
use App\Models\MunicipiosModel;
use App\Models\OrdenesModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Egreso extends Component
{
    use WithFileUploads;

    public $id;

    public $orden;

    public $numero_orden;

    public $egresos;

    public $precio_unitario_con_iva;

    public $stock_disponible;

    public $datos;

    public $fecha;

    public $nombre_sucursal;

    public $stock_transferencia;

    public $comision;

    public $listaEgresosAgregados = [];

    public $comentario;

    public $categoria_1;

    public $categoria_2;

    public $archivos;

    public $archivos_orden = [];

    public $fileCount = 1;

    public $id_file;

    public $datos_cargados = false;

    public $ciudad;

    public $departamento;

    public $nombre_registrado_por;

    public $impuesto;

    public $precio_unitario_sin_iva;

    public $tipo;
    
    public $misma_sucursal = false;

    public function mount(int $id)
    {
        $this->id = $id;

        $orden = OrdenesModel::where('id', $this->id)->where('tipo_orden', 'egreso')->first();

        if ($orden) {

            $this->orden = $orden;

            if (!empty($this->orden->adjuntos)) {
                $this->archivos_orden = json_decode($this->orden->adjuntos);
                $this->fileCount = count($this->archivos_orden); // Cuenta la cantidad de objetos en el array
            }


            $sucursal_usuario = SucursalesModel::find(Auth::user()->caja);

            if (($this->orden->id_sucursal == Auth::user()->caja) || strtolower($sucursal_usuario->nombre_sucursal) == 'corporativo') {
                $this->misma_sucursal = true;
            }

            $usuario = User::find($this->orden->registrado_por);

            $this->nombre_registrado_por = $usuario->name . " " . $usuario->apellidos;

            $this->datos = json_decode($this->orden->datos);

            $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();
            $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

            $this->comentario = json_decode($this->orden->comentarios);

            $date = new DateTime($this->datos->created_at);

            $formattedDate = $date->format('Y-m-d');

            $this->fecha = $formattedDate;

            $sucursal = SucursalesModel::find($this->orden->id_sucursal);

            $this->nombre_sucursal = $sucursal->nombre_sucursal;

            // Verifica si $this->orden->detalle no está vacío y es una cadena
            if (!empty($this->orden->detalle) && is_string($this->orden->detalle)) {
                $decodedData = json_decode($this->orden->detalle, true);

                // Verifica si json_decode no produjo un error y devolvió un array válido
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedData)) {
                    $this->listaEgresosAgregados = $decodedData;
                } else {
                    // Inicializa la variable en vacío si hay un error en la decodificación JSON
                    $this->listaEgresosAgregados = [];
                }
            } else {
                // Inicializa la variable en vacío si los datos no son válidos o están vacíos
                $this->listaEgresosAgregados = [];
            }
        } else {
            // La orden no existe, lanza una excepción o redirige a otra página
            abort(404, 'Orden no encontrada');
        }
    }

    public function registrarComentario()
    {
        $this->orden->comentarios = json_encode($this->comentario);

        if ($this->orden->save()) {
            $message = 'Comentario registrado';
            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        } else {
            $message = 'Error al registrar el comentario';
            $icon = 'error';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        }
    }

    #[On('agregar')]
    public function agregar($id)
    {
        $this->resetErrorBag();
        $this->egresos = null;
        $this->precio_unitario_con_iva = null;
        $this->precio_unitario_sin_iva = null;
        $this->stock_transferencia = null;
        $this->impuesto = null;
        $this->tipo = null;
        $this->categoria_1 = null;
        $this->categoria_2 = null;

        $egreso = EgresosModel::find($id);

        if ($egreso) {

            $this->egresos = $egreso;
            $this->categoria_1 = $this->egresos->categoria_1;
            $this->categoria_2 = $this->egresos->categoria_2;
        }
    }

    public function agregarListaEgresos()
    {

        $this->validacionCampos();

        $nuevoEgreso = [
            'id_egreso' => $this->egresos->id,
            'categoria_1' => $this->egresos->categoria_1,
            'categoria_2' => $this->egresos->categoria_2,
            'cantidad_egreso' => $this->stock_transferencia,
            'precio_unitario_con_iva' => $this->precio_unitario_con_iva,
            'precio_unitario_sin_iva' => $this->precio_unitario_sin_iva,
            'impuesto' => $this->impuesto,
            'descripcion' => $this->egresos->descripcion_egreso,
            'total' => -1 * ($this->stock_transferencia * $this->precio_unitario_con_iva),
        ];

        $existe = false;

        // Iterar sobre la lista de egresos agregados
        foreach ($this->listaEgresosAgregados as &$egreso) {
            if ($egreso['id_egreso'] === $nuevoEgreso['id_egreso'] && $egreso['precio_unitario_con_iva'] === $nuevoEgreso['precio_unitario_con_iva'] && $egreso['impuesto'] === $nuevoEgreso['impuesto']) {

                // Egreso ya existe, actualizar cantidad y total
                $egreso['cantidad_egreso'] += $nuevoEgreso['cantidad_egreso'];
                $egreso['total'] = -1 * ($egreso['cantidad_egreso'] * $egreso['precio_unitario_con_iva']);

                $detalle = json_decode(json_encode($this->listaEgresosAgregados));

                foreach ($detalle as $key => $val) {
                    if ($val->id_egreso === $egreso['id_egreso']) {
                        $val->cantidad_egreso = $egreso['cantidad_egreso'];
                        $val->total = $egreso['total'];
                    }
                }

                $this->orden->detalle = json_encode($detalle);

                $this->orden->save();

                $existe = true;
                $message = 'El egreso se agregó a la lista';
                $icon = 'success';
                $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
                $this->dispatch('recargarComponente');
                break;
            }
        }

        // Si no se encontró el egreso, agregarlo a la lista
        if (!$existe) {

            $this->listaEgresosAgregados[] = $nuevoEgreso;
            $this->orden->detalle = json_encode($this->listaEgresosAgregados);
            $this->orden->save();

            $message = 'El egreso se agregó a la lista';
            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
            $this->dispatch('recargarComponente');
        }
    }

    public function eliminarEgresoLista($id, $index)
    {
        $this->listaEgresosAgregados = array_filter($this->listaEgresosAgregados, function ($egreso, $key) use ($id, $index) {
            if ($egreso['id_egreso'] === $id && $key === $index) {
                return false; // Elimina el egreso del array si coincide el id y el índice
            }
            return true; // Mantén el egreso en el array
        }, ARRAY_FILTER_USE_BOTH);

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaEgresosAgregados));
        $this->orden->save();
    }

    public function validarPrecioUnitario()
    {
        // Remover espacios al inicio y al final
        $this->precio_unitario_con_iva = trim($this->precio_unitario_con_iva);

        // Verificar si el valor es un entero válido
        if (!ctype_digit($this->precio_unitario_con_iva)) {
            $message = "Ingrese un precio válido";
            $elementId = 'precio_unitario_con_iva';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->precio_unitario_con_iva = null;
            return false;
        }

        // Verificar si el valor es menor o igual a cero
        if ($this->precio_unitario_con_iva <= 0) {
            $message = "El precio no puede ser cero o negativo";
            $elementId = 'precio_unitario_con_iva';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->precio_unitario_con_iva = null;
            return false;
        }

        return true;
    }

    public function validarCantidadAgregar()
    {
        // Remover espacios al inicio y al final
        $this->stock_transferencia = trim($this->stock_transferencia);

        // Verificar si el valor es un entero válido
        if (!ctype_digit($this->stock_transferencia)) {
            $message = "Ingrese una cantidad válida";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        // Verificar si el valor es menor o igual a cero
        if ($this->stock_transferencia <= 0) {
            $message = "El cantidad no puede ser cero o negativa";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        return true;
    }

    public function eliminarArchivo($id)
    {
        $archivos = $this->orden->adjuntos;

        if (!empty($archivos)) {

            $archivos = json_decode($archivos); // Decodificar JSON como objetos

            foreach ($archivos as $key => $archivo) {

                // Encontró el archivo con el id
                if (strcmp(trim($archivo->id), trim($id)) === 0) {

                    // Eliminar archivo físicamente del sistema si es necesario
                    $rutaArchivo = storage_path('app/imagenes/egresos/' . $archivo->nombre);

                    if (file_exists($rutaArchivo)) {
                        unlink($rutaArchivo); // Elimina el archivo del sistema de archivos
                    }

                    unset($archivos[$key]); // Elimina el archivo del objeto
                    break; // Detiene la búsqueda
                }
            }
            // Reindexar el array para evitar problemas con índices no numéricos
            $archivos = array_values($archivos);
            // Reconvertir el objeto a JSON y guardar de nuevo en la base de datos
            $this->orden->adjuntos = json_encode($archivos);
            /* dd(print_r($archivos, true)); */
            $this->archivos_orden = json_decode($this->orden->adjuntos);
            $this->orden->save();
        }
    }

    public function updatedArchivos()
    {

        $archivo = $this->archivos;

        $this->validate([
            'archivos.*' => 'file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Generar un nuevo nombre de archivo
        $nuevoNombre = $this->orden->id . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();

        // Guardar cada archivo en la carpeta deseada
        $archivo->storeAs('imagenes/egresos', $nuevoNombre);

        $archivos = $this->orden->adjuntos;

        if (!empty($archivos)) {

            $archivos = json_decode($archivos);

            // Crear un nuevo objeto para el archivo
            $nuevoElemento = new \stdClass();
            $nuevoElemento->id = $this->id_file;
            $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
            $nuevoElemento->nombre = $nuevoNombre;
            $nuevoElemento->fileType = $archivo->getMimeType();

            // Agregar el nuevo objeto al final del array
            $archivos[] = $nuevoElemento;

            // Reconvertir el array de objetos a JSON y guardar de nuevo en la base de datos
            $this->orden->adjuntos = json_encode($archivos);
            $this->archivos_orden = json_decode($this->orden->adjuntos);
            $this->orden->save();
        } else {

            // Crear un nuevo objeto para el archivo
            $nuevoElemento = new \stdClass();
            $nuevoElemento->id = $this->id_file;
            $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
            $nuevoElemento->nombre = $nuevoNombre;
            $nuevoElemento->fileType = $archivo->getMimeType();
            // Agregar el nuevo objeto al final del array
            $archivos[] = $nuevoElemento;
            // Reconvertir el array de objetos a JSON y guardar de nuevo en la base de datos
            $this->orden->adjuntos = json_encode($archivos);
            $this->archivos_orden = json_decode($this->orden->adjuntos);
            $this->orden->save();
        }


        $this->archivos = null;

        $this->eliminarArchivosTemporales();
    }

    public function subirArchivo()
    {
        $this->id_file = uniqid();
    }

    public function eliminarArchivosTemporales()
    {
        $directorioTemp = storage_path('app/livewire-tmp');

        // Verificar si el directorio existe
        if (is_dir($directorioTemp)) {
            // Obtener todos los archivos en el directorio
            $archivos = glob($directorioTemp . '/*');

            foreach ($archivos as $archivo) {
                // Eliminar cada archivo
                if (is_file($archivo)) {
                    unlink($archivo);
                }
            }
        }
    }

    public function render()
    {
        $this->datos_cargados = true;
        return view('livewire.general.ordenes.egreso');
    }

    public function asignarPorcentaje()
    {
        $tipo_afectacion_impuesto = TipoAfectacionImpuestoModel::where('id', $this->tipo)->first();

        if ($tipo_afectacion_impuesto) {
            $this->impuesto = $tipo_afectacion_impuesto->impuesto;
            $this->validarTipoAfectacion();
        } else {
            $this->precio_unitario_con_iva = '';
            $this->precio_unitario_sin_iva = '';
            $this->impuesto = 0;
        }
    }

    public function validarTipoAfectacion()
    {
        if ($this->tipo == '') {
            $message = "Seleccione el tipo de afectación";
            $elementId = "precio_unitario_con_iva";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        } else {

            $tipo_afectacion_impuesto = TipoAfectacionImpuestoModel::where('id', $this->tipo)->first();

            $tarifa  = 0;

            if ($tipo_afectacion_impuesto) {
                $tarifa =  $tipo_afectacion_impuesto->impuesto;
            }

            if ($this->precio_unitario_con_iva == '') {
                $this->precio_unitario_sin_iva = '';
            } else {
                //validar si precio_unitario es número antes de realizar la operación
                $this->precio_unitario_sin_iva = number_format(($this->precio_unitario_con_iva  / ($tarifa / 100 + 1)), 2, '.', '');
            }
        }
    }

    public function validacionCampos()
    {
        return  $this->validate([
            'tipo' => 'required',
            'impuesto' => 'required',
            'precio_unitario_con_iva' => 'required',
            'stock_transferencia' => 'required',
        ], [

            'tipo.required' => 'El tipo de impuesto es requerido',
            'stock_transferencia.required' => 'La cantidad a agregar es requerida',
            'impuesto.required' => 'El impuesto es requerido',
            'precio_unitario_con_iva.required' => 'El precio con IVA es requerido',

        ]);
    }
}
