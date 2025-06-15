<?php

namespace App\Livewire\General\Ordenes;

use DateTime;
use App\Models\CuentasBancariasModel;
use App\Models\DepartamentosModel;
use App\Models\EgresosModel;
use App\Models\EmpresasModel;
use App\Models\InventarioModel;
use App\Models\MunicipiosModel;
use App\Models\OrdenesModel;
use App\Models\PagosOrdenes;
use App\Models\ProveedoresModel;
use App\Models\SucursalesModel;
use App\Models\TipoAfectacionImpuestoModel;
use App\Models\User;
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

    public $categoria_1;

    public $categoria_2;

    public $tipo;

    public $precio_unitario_con_iva;

    public $precio_unitario_sin_iva;

    public $impuesto;

    public $stock_disponible;

    public $datos;

    public $fecha;

    public $fecha_pago_factura;

    public $nombre_sucursal;

    public $id_sucursal;

    public $stock_transferencia;

    public $listaEgresosAgregados = [];

    public $comentario;

    public $historialComentarios;

    public $ciudad;

    public $departamento;

    public $nombre_registrado_por;

    public $misma_sucursal = false;

    public $empresa_factura;

    public $archivos_orden;

    public $archivos;

    public $id_file;

    public $valor_total_orden;

    public $forma_pago = '';

    public $catalogoVisible = true;

    public $monto_credito;

    public $activoCargarComprobante = false;

    public $pagoOrdenes;

    public $opcionesPagoActivado = false;

    public $pagoOrdenesMonto;

    public $estadoOrden;

    public $ordenCerrada = false;

    public $fecha_pago;

    public $datos_cuentas_banco;

    public $seleccion_banco;

    public $plazo_pago;

    public $aplicar_pago = false;

    public $estado_envio = 0;

    public $mostrar_adjunto_envio = false;

    public $archivos_envio;

    public $enviar_conciliar = false;

    public $adjuntos_envios;

    /* Variables para la edición de datos del proveedor */

    public $telefono_edicion;

    public $grupo_edicion;

    public $nombreLegal_edicion;

    public $nombreComercial_edicion;

    public $nit_edicion;

    public $sucursal_edicion;

    public $direccion_edicion;

    public $barrio_localidad_edicion;

    public $ciudad_edicion;

    public $idciudad_edicion;

    public $departamento_edicion;

    public $iddepartamento_edicion;

    public $correo_edicion;

    public $nombreEncargado_edicion;

    public $descripcion_edicion;

    public $empresaFactura_edicion;

    /* Fin de variables para la edición de datos del proveedor */

    /* Inicio de variables para la creación de un nuevo proveedor */

    public $telefono_creacion;

    public $grupo_creacion;

    public $nombreLegal_creacion;

    public $nombreComercial_creacion;

    public $nit_creacion;

    public $sucursal_creacion;

    public $direccion_creacion;

    public $barrio_localidad_creacion;

    public $ciudad_creacion;

    public $idciudad_creacion;

    public $departamento_creacion;

    public $iddepartamento_creacion;

    public $correo_creacion;

    public $nombreEncargado_creacion;

    public $descripcion_creacion;

    public $empresaFactura_creacion;

    /* Fin de variables para la creación de un nuevo proveedor */

    public $listaMunicipios;

    /* Inicio de variables para cambiar el proveedor de la orden. */

    public $id_proveedor;

    public $listaProveedores;

    public $buscar_proveedor;

    /* Fin de variables para cambiar el proveedor de la orden. */

    public function mount(int $id)
    {
        $this->id = $id;

        $this->fecha_pago = date('Y-m-d');

        $orden = OrdenesModel::where('id', $this->id)->where('tipo_orden', 'egreso')->first();

        if ($orden) {

            $this->orden = $orden;

            if ($this->orden->estado_envio == 2 && !empty($this->orden->adjuntos_envios)) {
                $this->enviar_conciliar = true;
            }

            if ($this->orden->forma_pago !== '') {
                $this->catalogoVisible = false;
            }

            if ($this->orden->estado_orden == 2) {
                $this->ordenCerrada = true;
            }

            $this->estado_envio = $this->orden->estado_envio;

            $this->adjuntos_envios = json_decode($this->orden->adjuntos_envios);

            $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);

            $this->pagoOrdenes = PagosOrdenes::where('orden', $this->id)->first();

            if (!empty($this->orden->adjuntos)) {
                $this->archivos_orden = json_decode($this->orden->adjuntos);
            }

            $sucursal_usuario = SucursalesModel::find(Auth::user()->caja);

            if (($this->orden->id_sucursal == Auth::user()->caja) || strtolower($sucursal_usuario->nombre_sucursal) == 'corporativo') {
                $this->misma_sucursal = true;
            }

            $this->datos = json_decode($this->orden->datos);

            $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();

            $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

            $this->datos_cuentas_banco = CuentasBancariasModel::where('empresa', $this->datos->empresa_factura)->where('estado', 1)->get();

            $usuario = User::find($this->orden->registrado_por);

            $this->nombre_registrado_por = $usuario->name . " " . $usuario->apellidos;

            $this->historialComentarios = json_decode($this->orden->comentarios);

            $date = new DateTime($this->datos->created_at);

            $formattedDate = $date->format('Y-m-d H:i:s');

            $this->fecha = $formattedDate;

            $sucursal = SucursalesModel::find($this->orden->id_sucursal);

            $this->nombre_sucursal = $sucursal->nombre_sucursal;

            $this->id_sucursal = $sucursal->id;

            $this->empresa_factura = EmpresasModel::find($this->datos->empresa_factura);

            /* $this->empresa_factura = $this->empresa_factura->nombre_legal;
 */
            // Verifica si $this->orden->detalle no está vacío y es una cadena
            if (!empty($this->orden->detalle) && is_string($this->orden->detalle)) {
                $decodedData = json_decode($this->orden->detalle, true);

                // Verifica si json_decode no produjo un error y devolvió un array válido
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedData)) {
                    $this->listaEgresosAgregados = $decodedData;
                    foreach ($this->listaEgresosAgregados as $pr) {
                        $this->valor_total_orden += $pr['total'];
                    }
                } else {
                    // Inicializa la variable en vacío si hay un error en la decodificación JSON
                    $this->listaEgresosAgregados = [];
                }
            } else {
                // Inicializa la variable en vacío si los datos no son válidos o están vacíos
                $this->listaEgresosAgregados = [];
            }

            /* Seteo de datos para edición */

            $this->telefono_edicion = $this->datos->telefono;
            $this->nombreComercial_edicion = $this->datos->nombre_comercial;
            $this->grupo_edicion = $this->datos->grupo;
            $this->nombreLegal_edicion = $this->datos->nombre_legal;
            $this->nit_edicion = $this->datos->nit;
            $this->sucursal_edicion = $this->datos->sucursal;
            $this->direccion_edicion = $this->datos->direccion;
            $this->barrio_localidad_edicion = $this->datos->barrio_localidad;
            $this->ciudad_edicion = $this->ciudad->nombre_municipio;
            $this->departamento_edicion = $this->departamento->nombre_departamento;
            $this->idciudad_edicion = $this->datos->ciudad;
            $this->iddepartamento_edicion = $this->datos->departamento;
            $this->correo_edicion = $this->datos->correo;
            $this->nombreEncargado_edicion = $this->datos->nombre_encargado;
            $this->empresaFactura_edicion = $this->datos->empresa_factura;
            $this->descripcion_edicion = $this->datos->descripcion;



            /* Fin de seteo de datos para edición */
        } else {
            // La orden no existe, lanza una excepción o redirige a otra página
            abort(404, 'Orden no encontrada');
        }
    }

    public function registrarComentario()
    {
        if (empty(trim($this->comentario))) {
            $message = 'Comentario vacio';
            $icon = 'warning';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        } else {
            // Obtener los comentarios existentes, si hay
            $comentariosExistentes = json_decode($this->orden->comentarios, true) ?? [];

            // Agregar el nuevo comentario al arreglo de comentarios existentes
            $comentariosExistentes[] = [
                'idusuario' => Auth::user()->id,
                'nombre' => Auth::user()->name . " " . Auth::user()->apellidos,
                'comentario' => $this->comentario,
                'fecha' => now()->toDateTimeString(), // Agregar la fecha actual
            ];

            // Guardar el historial actualizado
            $this->orden->comentarios = json_encode($comentariosExistentes);

            if ($this->orden->save()) {
                $this->comentario = null;
                $this->historialComentarios = json_decode($this->orden->comentarios);
                $this->dispatch('scrollToBottom');
                $message = 'Comentario registrado';
                $icon = 'success';
                $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
            } else {
                $this->comentario = null;
                $message = 'Error al registrar el comentario';
                $icon = 'error';
                $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
            }
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
            $this->categoria_1 = $this->egresos->categoria1->nombre_categoria;
            $this->categoria_2 = $this->egresos->categoria2->nombre_categoria;
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

    public function modificarCantidadProducto(&$productos, $id_producto, $nueva_cantidad)
    {
        foreach ($productos as &$producto) {
            if ($producto['id_inventario'] == $id_producto) {
                $producto['cantidad_producto'] = $nueva_cantidad;
                return true; // Producto encontrado y cantidad modificada
            }
        }
        return false; // Producto no encontrado
    }

    public function eliminarCatalogoLista($id)
    {    // Encuentra el producto que se va a eliminar para obtener su cantidad
        $cantidadEgreso = 0;
        $this->listaEgresosAgregados = array_filter($this->listaEgresosAgregados, function ($egreso) use ($id, &$cantidadEgreso) {
            if ($egreso['id_egreso'] === $id) {
                $cantidadEgreso = $egreso['cantidad_egreso']; // Obtén la cantidad del producto
                $this->valor_total_orden = -1 * ($this->valor_total_orden + $egreso['total']);
                return false; // Elimina el producto del array
            }
            return true; // Mantén el producto en el array
        });

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaEgresosAgregados));
        $this->orden->save();
    }

    public function disminuirCatalogoLista($id)
    {
        // Recorre los productos para disminuir en 1 la cantidad del producto con el ID especificado
        foreach ($this->listaEgresosAgregados as &$egreso) {
            if ($egreso['id_egreso'] === $id) {
                // Si la cantidad es mayor a 1, solo restamos 1
                if ($egreso['cantidad_egreso'] > 1) {
                    $egreso['cantidad_egreso']--;
                    $egreso['total'] = -1 * ($egreso['total'] - $egreso['precio_unitario_con_iva']);
                    $this->valor_total_orden = $this->valor_total_orden - $egreso['precio_unitario_con_iva'];
                } else {
                    // Si la cantidad es 1, lo eliminamos de la lista
                    $this->listaEgresosAgregados = array_filter($this->listaEgresosAgregados, function ($egreso) use ($id) {
                        return $egreso['id_egreso'] !== $id;
                    });
                }
                break;
            }
        }

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaEgresosAgregados));
        $this->orden->save();
    }

    public function aumentarCatalogoLista($id)
    {
        // Recorre la lista de productos para encontrar el producto con el ID especificado
        foreach ($this->listaEgresosAgregados as &$egreso) {
            if ($egreso['id_egreso'] === $id) {
                // Aumenta la cantidad del producto en 1

                $egreso['cantidad_egreso']++;
                $egreso['total'] = -1 * ($egreso['total'] + $egreso['precio_unitario_con_iva']);
                $this->valor_total_orden = $this->valor_total_orden + $egreso['precio_unitario_con_iva'];
                break;
            }
        }

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaEgresosAgregados));
        $this->orden->save();
    }

    private function validarFechaPagoFactura()
    {
        $rules = [
            'fecha_pago_factura' => 'required|date',
        ];

        $messages = [
            'fecha_pago_factura.required' => 'La fecha de pago es requerida.',
        ];

        $this->validate($rules, $messages);
    }

    public function updatedArchivosEnvio()
    {

        $this->validarFechaPagoFactura();

        $archivo = $this->archivos_envio;
        $this->validate([
            'archivos_envio' => 'file|mimes:jpeg,png,pdf|max:2048',
        ], [
            'archivos_envio.file' => 'El archivo debe ser un archivo válido.',
            'archivos_envio.mimes' => 'Solo se permiten archivos de tipo JPEG, PNG o PDF.',
            'archivos_envio.max' => 'El tamaño máximo del archivo es 2MB.',
        ]);
        // Generar un nuevo nombre de archivo
        $nuevoNombre = $this->orden->id . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
        // Guardar cada archivo en la carpeta deseada
        $archivo->storeAs('imagenes/egresos', $nuevoNombre);

        // Crear un nuevo objeto para el archivo
        $nuevoElemento = new \stdClass();
        $nuevoElemento->id = $this->id_file;
        $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
        $nuevoElemento->nombre = $nuevoNombre;
        $nuevoElemento->fecha = $this->fecha_pago_factura;
        $nuevoElemento->fileType = $archivo->getMimeType();

        // Reconvertir el array de objetos a JSON y guardar de nuevo en la base de datos
        $this->orden->estado_envio = 2;
        $this->adjuntos_envios = $nuevoElemento;
        $this->orden->adjuntos_envios = json_encode($nuevoElemento);
        $this->orden->save();
        $this->enviar_conciliar = true;
        $icon = 'success';
        $this->dispatch('mensajes', message: "Comprobante de envío agregado", icon: $icon, state: false);
    }

    public function updatedArchivos()
    {
        $archivo = $this->archivos;

        $this->validate([
            'archivos' => 'file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($this->forma_pago === 'efectivo'  || $this->forma_pago === 'banco') {

            $this->validarFechaPago();

            if ($this->forma_pago === 'banco') {
                $this->validarCuentaBanco();
            }
        } else if ($this->forma_pago === 'credito') {
            $this->validarPlazoPago();
        }

        if ($this->aplicar_pago == true) {

            $this->aplicar_pago = false;

            $this->opcionesPagoActivado = true;
        }

        $registroPago = PagosOrdenes::where('orden', $this->orden->id)->first();

        if ($registroPago) {
            $registroPago->delete();
        }

        // Generar un nuevo nombre de archivo
        $nuevoNombre = $this->orden->id . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();

        // Guardar cada archivo en la carpeta deseada
        $archivo->storeAs('imagenes/egresos', $nuevoNombre);

        $archivos = $this->orden->adjuntos;
        //Insertar los valores en Pagos de Ordenes
        $pagosOrdenes = new PagosOrdenes();
        $pagosOrdenes->orden = $this->orden->id;
        $pagosOrdenes->fecha = strtotime($this->fecha_pago);
        $pagosOrdenes->id_empresa = $this->datos->empresa_factura;
        $pagosOrdenes->nombre_empresa = $this->empresa_factura->nombre_legal;

        $pagosOrdenes->id_sucursal = $this->orden->id_sucursal;
        $pagosOrdenes->nombre_sucursal = $this->nombre_sucursal;

        //Fin actualizar estados de orden
        $this->opcionesPagoActivado = false;

        if ($this->forma_pago == 'banco') {
            //Obtener datos de banco 
            $banco = CuentasBancariasModel::where('id', $this->seleccion_banco)->where('estado', 1)->first();
            $pagosOrdenes->id_cuenta_banco = $banco->id;
            $pagosOrdenes->numero_cuenta_banco = $banco->numero_cuenta;

            $pagosOrdenes->id_forma_pago = 2;
            $pagosOrdenes->nombre_forma_pago = 'banco';
            $pagosOrdenes->id_estado_pago = 1;
            $pagosOrdenes->nombre_estado_pago = 'por validar';
            $pagosOrdenes->dias_plazo_pago = 0;

            $this->orden->forma_pago = 'banco';
            $this->orden->estado_pago = 'por validar';
            $this->orden->estado_orden = '1';
        } else if ($this->forma_pago == 'credito') {

            $pagosOrdenes->id_cuenta_banco = 0;
            $pagosOrdenes->numero_cuenta_banco = 0;
            $pagosOrdenes->id_forma_pago = 3;
            $pagosOrdenes->nombre_forma_pago = 'credito';
            $pagosOrdenes->id_estado_pago = 3;
            $pagosOrdenes->nombre_estado_pago = 'credito';
            $pagosOrdenes->dias_plazo_pago = $this->plazo_pago;

            $this->orden->forma_pago = 'credito';
            $this->orden->estado_pago = 'credito';
            $this->orden->estado_orden = '3';
        }

        $pagosOrdenes->monto = $this->valor_total_orden;

        $pagosOrdenes->save();

        $this->pagoOrdenes = PagosOrdenes::where('orden', $this->id)->first();

        //Fin de Insertar los valores en Pagos de Ordenes

        if (!empty($archivos)) {

            $archivos = json_decode($archivos);

            // Crear un nuevo objeto para el archivo
            $nuevoElemento = new \stdClass();
            $nuevoElemento->id = $this->id_file;
            $nuevoElemento->id_pago_ordenes = $pagosOrdenes->id;
            $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
            $nuevoElemento->nombre = $nuevoNombre;
            $nuevoElemento->fileType = $archivo->getMimeType();

            // Agregar el nuevo objeto al final del array
            $archivos[] = $nuevoElemento;

            // Reconvertir el array de objetos a JSON y guardar de nuevo en la base de datos
            $this->orden->adjuntos = json_encode($archivos);
            $this->archivos_orden = json_decode($this->orden->adjuntos);
        } else {
            // Crear un nuevo objeto para el archivo
            $nuevoElemento = new \stdClass();
            $nuevoElemento->id = $this->id_file;
            $nuevoElemento->id_pago_ordenes = $pagosOrdenes->id;
            $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
            $nuevoElemento->nombre = $nuevoNombre;
            $nuevoElemento->fileType = $archivo->getMimeType();
            // Agregar el nuevo objeto al final del array
            $archivos[] = $nuevoElemento;
            // Reconvertir el array de objetos a JSON y guardar de nuevo en la base de datos
            $this->orden->adjuntos = json_encode($archivos);
            $this->archivos_orden = json_decode($this->orden->adjuntos);
        }

        $this->orden->save();

        $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);

        $this->archivos = null;

        $this->eliminarArchivosTemporales();

        $icon = 'success';
        $this->dispatch('mensajes', message: "Pago agregado", icon: $icon, state: false);
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

    public function eliminarArchivo($id, $id_pago_orden)
    {
        $registroPago = PagosOrdenes::find($id_pago_orden);

        $estado_pago = $registroPago->id_estado_pago;

        if ($estado_pago != 2) {

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
                        $icon = 'success';
                        $this->dispatch('mensajes', message: "Pago eliminado", icon: $icon, state: false);
                        break; // Detiene la búsqueda
                    }
                }

                // Reconvertir el objeto a JSON y guardar de nuevo en la base de datos
                $this->orden->adjuntos = [];
                /* dd(print_r($archivos, true)); */
                $this->archivos_orden = [];
                $this->orden->forma_pago = '';
                $this->orden->estado_pago = '';
                $this->orden->estado_orden = '';
                $this->orden->save();

                $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);
                $this->opcionesPagoActivado = false;

                $registroPago = PagosOrdenes::find($id_pago_orden);

                if ($registroPago) {
                    $registroPago->delete();
                }

                $this->pagoOrdenes = PagosOrdenes::where('orden', $this->id)->first();

                if (!$this->pagoOrdenes) {
                    $this->opcionesPagoActivado = true;
                    $this->forma_pago = "";
                }

                $this->asignarFormaPago($this->forma_pago);
            }
        } else if ($estado_pago == 2) {
            $icon = 'warning';
            $this->dispatch('mensajes', message: "No se puede eliminar el pago validado", icon: $icon, state: false);
        }
    }

    public function eliminarArchivoEnvio()
    {
        // Eliminar archivo físicamente del sistema si es necesario
        $rutaArchivo = storage_path('app/imagenes/egresos/' . $this->adjuntos_envios->nombre);

        if (file_exists($rutaArchivo)) {

            unlink($rutaArchivo); // Elimina el archivo del sistema de archivos

            $this->orden->estado_envio = 0;
            $this->orden->adjuntos_envios = NULL;
            $this->orden->save();

            $this->adjuntos_envios = NULL;
            $this->enviar_conciliar = false;
            $this->estado_envio = 0;

            $icon = 'success';
            $this->dispatch('mensajes', message: "Comprobante eliminado", icon: $icon, state: false);
        }
    }

    public function asignarFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
        if (trim($this->forma_pago != '')) {
            $this->catalogoVisible = false;
        } else {
            $this->catalogoVisible = true;
        }
    }

    public function validarMontoCredito()
    {
        if (!empty(trim($this->monto_credito)) &&  is_numeric($this->monto_credito)) {
            $montoTotal = $this->pagoOrdenesMonto + $this->monto_credito;
            if ($montoTotal > $this->valor_total_orden) {
                $this->monto_credito = 0;
                $icon = 'error';
                $this->dispatch('mensajes', message: "El valor ingresado supera el valor de la orden.", icon: $icon, state: false);
            }
        }
    }

    public function mostrarOpcionesPago()
    {
        $this->opcionesPagoActivado = true;
    }

    public function darStatusOrden($status)
    {
        $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-gray-400 rounded-lg"><i class="fa-solid fa-circle-question"></i> Sin Asignar</span>';

        if ($status == 1) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-red-700 rounded-lg"><i class="fa-solid fa-spinner"></i> Por validar</span>';
        } else if ($status == 2) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-green-700 rounded-lg"><i class="fa-solid fa-lock"></i> Validado</span>';
        } else if ($status == 3) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-yellow-500 rounded-lg"><i class="fa-solid fa-credit-card"></i> Crédito</span>';
        }

        return $estadoOrden;
    }

    public function cerrarOrden()
    {
        $this->orden->estado_pago = 'validado';
        $this->orden->estado_orden = 2;
        $this->orden->save();
        $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);

        $this->pagoOrdenes->id_estado_pago = 2;
        $this->pagoOrdenes->nombre_estado_pago = 'validado';
        $this->pagoOrdenes->save();

        $this->ordenCerrada = true;
    }

    public function confirmarPagoEfectivo()
    {
        if ($this->aplicar_pago == true) {

            $this->aplicar_pago = false;

            if ($this->pagoOrdenes && isset($this->pagoOrdenes->orden)) {
                $registroPago = PagosOrdenes::where('orden', $this->pagoOrdenes->orden)->first();

                if ($registroPago) {
                    $registroPago->delete();
                }
            }

            $this->orden->adjuntos = [];
            $this->orden->forma_pago = "";
            $this->orden->estado_pago = "";
            $this->orden->estado_orden = NULL;
            $this->orden->save();
        }

        //Insertar los valores en Pagos de Ordenes
        $pagosOrdenes = new PagosOrdenes();
        $pagosOrdenes->orden = $this->orden->id;
        $pagosOrdenes->fecha = time();
        $pagosOrdenes->id_empresa = $this->datos->empresa_factura;
        $pagosOrdenes->nombre_empresa = $this->empresa_factura->nombre_legal;
        //No aplica ya que es un pago en efectivo
        $pagosOrdenes->id_cuenta_banco = 0;
        $pagosOrdenes->numero_cuenta_banco = 0;

        $pagosOrdenes->id_sucursal = $this->orden->id_sucursal;
        $pagosOrdenes->nombre_sucursal = $this->nombre_sucursal;
        $pagosOrdenes->id_forma_pago = 1;
        $pagosOrdenes->nombre_forma_pago = 'efectivo';
        $pagosOrdenes->id_estado_pago = 1;
        $pagosOrdenes->nombre_estado_pago = 'por validar';
        $pagosOrdenes->dias_plazo_pago = 0;
        $pagosOrdenes->monto = $this->valor_total_orden;
        $pagosOrdenes->save();

        $this->pagoOrdenes = PagosOrdenes::where('orden', $this->id)->first();

        //Fin de Insertar los valores en Pagos de Ordenes
        //Actualizar estados de orden
        $this->orden->forma_pago = 'efectivo';
        $this->orden->estado_pago = 'por validar';
        $this->orden->estado_orden = '1';
        $this->orden->save();
        $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);
        //Fin actualizar estados de orden
        $this->opcionesPagoActivado = false;

        $icon = 'success';
        $this->dispatch('mensajes', message: "Pago agregado", icon: $icon, state: false);
    }

    public function eliminarPagoEfectivo($id_orden, $id_pago_ordenes)
    {
        //Eliminamos el registro de la tabla pagos_ordenes
        $registroPago = PagosOrdenes::find($id_pago_ordenes);

        if ($registroPago) {
            $registroPago->delete();
        }

        $this->pagoOrdenes = PagosOrdenes::where('orden', $this->id)->first();

        $this->orden->forma_pago = '';
        $this->orden->estado_pago = '';
        $this->orden->estado_orden = '';
        $this->orden->save();

        $this->estadoOrden = $this->darStatusOrden($this->orden->estado_orden);

        $this->catalogoVisible = true;

        $this->forma_pago = '';

        $this->aplicar_pago = true;

        $this->opcionesPagoActivado = true;

        $icon = 'success';
        $this->dispatch('mensajes', message: "Pago eliminado", icon: $icon, state: false);
    }

    public function validarFechaPago()
    {
        $date = new DateTime($this->datos->created_at);

        $formattedDate = $date->format('Y-m-d');

        return $this->validate(
            [
                'fecha_pago' => 'required|date|before_or_equal:today',
            ],
            [
                'fecha_pago.before_or_equal' => 'La fecha no puede ser mayor que la fecha actual.',
                'fecha_pago.required' => 'La fecha es obligatoria.',
            ]
        );
    }

    public function validarCuentaBanco()
    {
        return $this->validate(
            [
                'seleccion_banco' => 'required',
            ],
            [
                'seleccion_banco.required' => 'Seleccione una cuenta de banco.',
            ]
        );
    }

    public function validarPlazoPago()
    {
        return $this->validate(
            [
                'plazo_pago' => 'required',
            ],
            [
                'plazo_pago.required' => 'Seleccione un plazo de pago.',
            ]
        );
    }

    public function aplicarPago()
    {
        $this->aplicar_pago =  true;
        $this->orden->forma_pago = "";
        $this->forma_pago = "";
    }

    public function estadoEnvio()
    {
        if ($this->estado_envio == 0) {

            $this->orden->estado_envio = 0;
            $this->orden->save();

            $this->mostrar_adjunto_envio = false;

            $icon = 'success';
            $this->dispatch('mensajes', message: "Estado de envío actualizado", icon: $icon, state: false);
        } else if ($this->estado_envio == 1) {

            $this->orden->estado_envio = 1;
            $this->orden->save();

            $this->mostrar_adjunto_envio = false;

            $icon = 'success';
            $this->dispatch('mensajes', message: "Estado de envío actualizado", icon: $icon, state: false);
        } else if ($this->estado_envio == 2) {
            $this->mostrar_adjunto_envio = true;
        }
    }

    public function darStatusEnvio($status)
    {
        $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-red-700 rounded-lg"><i class="fa-solid fa-spinner"></i> Por despachar</span>';

        if ($status == 1) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-yellow-500 rounded-lg"><i class="fa-solid fa-truck-moving"></i> Despachado</span>';
        } else if ($status == 2) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-blue-500 rounded-lg"><i class="fa-solid fa-cloud-arrow-up"></i> Cargar comprobante</span>';
        } else if ($status == 3) {
            $estadoOrden = '<span class="px-1 py-1 text-sm text-white bg-green-500 rounded-lg"><i class="fa-regular fa-handshake"></i> Conciliado</span>';
        }

        return $estadoOrden;
    }

    public function conciliarEnvio()
    {
        $this->orden->estado_envio = 3;
        $this->estado_envio = 3;
        $this->orden->save();
        $icon = 'success';
        $this->dispatch('mensajes', message: "Orden conciliada", icon: $icon, state: false);
    }

    public function buscarCiudad()
    {
        if (!empty(trim($this->ciudad_edicion))) {

            $this->listaMunicipios = MunicipiosModel::where('nombre_municipio', 'like', '%' . $this->ciudad_edicion . '%')
                ->orderBy('nombre_municipio')
                ->take(5)
                ->get();

            $this->idciudad_edicion = null;
            $this->departamento_edicion = null;
            $this->iddepartamento_edicion = null;
        } else {

            $this->listaMunicipios = null;
        }
    }

    public function setearNombreCiudad($id)
    {
        $this->listaMunicipios = null;

        $nombreCiudad = MunicipiosModel::find($id);

        if ($nombreCiudad) {
            $this->ciudad_edicion = $nombreCiudad->nombre_municipio;
            $this->idciudad_edicion = $id;
            $departamento = DepartamentosModel::where('codigo_dane', $nombreCiudad->codigo_departamento)->first();
            $this->departamento_edicion = $departamento->nombre_departamento;
            $this->iddepartamento_edicion = $departamento->id;
        }
    }

    public function actualizarProveedor()
    {
        $this->validacionCamposActualizacionProveedor();

        // Actualizar los datos
        $this->datos->telefono = $this->telefono_edicion;
        $this->datos->nombre_comercial = $this->nombreComercial_edicion;
        $this->datos->grupo = $this->grupo_edicion;
        $this->datos->nombre_legal = $this->nombreLegal_edicion;
        $this->datos->nit = $this->nit_edicion;
        $this->datos->sucursal = $this->sucursal_edicion;
        $this->datos->direccion = $this->direccion_edicion;
        $this->datos->barrio_localidad = $this->barrio_localidad_edicion;
        $this->datos->ciudad = $this->idciudad_edicion;
        $this->datos->departamento = $this->iddepartamento_edicion;
        $this->datos->correo = $this->correo_edicion;
        $this->datos->nombre_encargado = $this->nombreEncargado_edicion;

        $this->datos->empresa_factura = $this->empresaFactura_edicion;
        $this->datos->descripcion = $this->descripcion_edicion;
        //Actualizar la información de la empresa factura
        $this->empresa_factura = EmpresasModel::find($this->empresaFactura_edicion);

        $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();
        $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

        $this->datos = json_encode($this->datos);
        $this->orden->datos_empresa = json_encode($this->empresa_factura);
        $this->orden->datos = $this->datos;
        $this->orden->save();

        $this->datos = json_decode($this->orden->datos);

        $proveedor = ProveedoresModel::find($this->datos->id);

        if ($proveedor) {
            // Actualizar los datos del proveedor
            $proveedor->update((array) $this->datos);
        }

        $this->dispatch('datos-actualizados', [
            'datos' => $this->datos,
            'ciudad' => $this->ciudad->nombre_municipio,
            'departamento' => $this->departamento->nombre_departamento
        ]);
    }

    public function buscarProveedor()
    {
        if (!empty(trim($this->buscar_proveedor))) {

            $this->listaProveedores = ProveedoresModel::where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('nombre_legal', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('nit', 'like', '%' . $this->buscar_proveedor . '%')
                    ->orWhere('telefono', 'like', '%' . $this->buscar_proveedor . '%');
            })
                /* ->where('sucursal', $this->sucursal_origen) */
                ->where('estado', 1)
                ->orderBy('nombre_legal')
                ->take(5)
                ->get();

            $this->id_proveedor = null;
        } else {
            $this->listaProveedores = null;
            $this->id_proveedor = null;
        }
    }

    public function setearNombreProveedor($id)
    {

        $this->listaProveedores = null;

        $proveedor = ProveedoresModel::find($id);

        if ($proveedor) {
            $this->buscar_proveedor = $proveedor->nombre_legal;
            $this->id_proveedor = $proveedor->id;
        }
    }

    public function cambiarProveedorOrden()
    {
        $proveedor = ProveedoresModel::find($this->id_proveedor);

        if ($proveedor) {

            $this->orden->datos = $proveedor;
            $this->orden->save();

            $this->datos = json_decode($this->orden->datos);
            $this->datos->empresa_factura = $this->empresa_factura->id;
            // Actualizar los datos
            $this->telefono_edicion = $this->datos->telefono;
            $this->nombreComercial_edicion = $this->datos->nombre_comercial;
            $this->grupo_edicion = $this->datos->grupo;
            $this->nombreLegal_edicion = $this->datos->nombre_legal;
            $this->nit_edicion = $this->datos->nit;
            $this->sucursal_edicion = $this->datos->sucursal;
            $this->direccion_edicion = $this->datos->direccion;
            $this->barrio_localidad_edicion = $this->datos->barrio_localidad;
            $this->idciudad_edicion = $this->datos->ciudad;
            $this->iddepartamento_edicion = $this->datos->departamento;
            $this->correo_edicion = $this->datos->correo;
            $this->nombreEncargado_edicion = $this->datos->nombre_encargado;
            $this->empresaFactura_edicion = $this->datos->empresa_factura;
            $this->descripcion_edicion = $this->datos->descripcion;

            $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();
            $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

            $this->datos = json_encode($this->datos);
            $this->orden->datos = $this->datos;
            $this->orden->save();

            $this->datos = json_decode($this->orden->datos);
            $this->reinicializarDatosCreacionProveedor();

            $this->dispatch('datos-actualizados', [
                'datos' => $this->datos,
                'ciudad' => $this->ciudad->nombre_municipio,
                'departamento' => $this->departamento->nombre_departamento
            ]);
        }
    }

    public function buscarCiudadCreacion()
    {
        if (!empty(trim($this->ciudad_creacion))) {

            $this->listaMunicipios = MunicipiosModel::where('nombre_municipio', 'like', '%' . $this->ciudad_creacion . '%')
                ->orderBy('nombre_municipio')
                ->take(5)
                ->get();

            $this->idciudad_creacion = null;
            $this->departamento_creacion = null;
            $this->iddepartamento_creacion = null;
        } else {

            $this->listaMunicipios = null;
        }
    }

    public function setearNombreCiudadCreacion($id)
    {
        $this->listaMunicipios = null;

        $nombreCiudad = MunicipiosModel::find($id);

        if ($nombreCiudad) {
            $this->ciudad_creacion = $nombreCiudad->nombre_municipio;
            $this->idciudad_creacion = $id;
            $departamento = DepartamentosModel::where('codigo_dane', $nombreCiudad->codigo_departamento)->first();
            $this->departamento_creacion = $departamento->nombre_departamento;
            $this->iddepartamento_creacion = $departamento->id;
        }
    }

    public function validacionCamposActualizacionProveedor()
    {
        return  $this->validate([
            'nombreComercial_edicion' => 'required|string|max:255',
            'nombreLegal_edicion' => 'required|string|max:255',
            'grupo_edicion' => 'required|string|max:255',
            'telefono_edicion' => 'required|integer|unique:proveedores,telefono,' . $this->datos->id,
            'nit_edicion' => 'required|string|max:20',
            'iddepartamento_edicion' => 'required',
            'idciudad_edicion' => 'required|string|max:100',
            'direccion_edicion' => 'required|string|max:255',
            'sucursal_edicion' => 'required|string|max:255',
            'correo_edicion' => 'required|email|max:255',
            'nombreEncargado_edicion' => 'required|string|max:255',
            'descripcion_edicion' => 'required|string|max:1000',
            'barrio_localidad_edicion' => 'required|string|max:255',
            'empresaFactura_edicion' => 'required|string|max:255',

        ], [
            'nombreLegal_edicion.required' => 'El nombre legal es obligatorio.',
            'nombreComercial_edicion.required' => 'El nombre comercial es obligatorio.',
            'grupo_edicion.required' => 'El grupo es obligatorio.',
            'telefono_edicion.required' => 'El teléfono es obligatorio.',
            'telefono_edicion.integer' => 'El teléfono debe ser númerico.',
            'nit_edicion.required' => 'El NIT es obligatorio.',
            'telefono_edicion.unique' => 'El teléfono ya está registrado.',
            'iddepartamento_edicion.required' => 'El departamento es obligatorio.',
            'idciudad_edicion.required' => 'La ciudad es obligatoria.',
            'correo_edicion.required' => 'El correo electrónico es obligatorio.',
            'correo_edicion.email' => 'El correo debe ser una dirección de email válida.',
            'direccion_edicion.required' => 'La dirección es obligatoria.',
            'sucursal_edicion.required' => 'La sucursal es obligatoria.',
            'nombreEncargado_edicion.required' => 'El nombre del encargado es obligatorio.',
            'descripcion_edicion.required' => 'La descripción es obligatoria.',
            'empresaFactura_edicion.required' => 'No seleccionó con que empresa factura.',
            'barrio_localidad_edicion.required' => 'El barrio o localidad es obligatorio.',
        ]);
    }

    public function validacionCamposCreacionProveedor()
    {
        return  $this->validate([
            'nombreComercial_creacion' => 'required|string|max:255',
            'nombreLegal_creacion' => 'required|string|max:255',
            'grupo_creacion' => 'required|string|max:255',
            'telefono_creacion' => 'required|integer|unique:proveedores,telefono',
            'nit_creacion' => 'required|string|max:20',
            'iddepartamento_creacion' => 'required',
            'idciudad_creacion' => 'required|string|max:100',
            'direccion_creacion' => 'required|string|max:255',
            'sucursal_creacion' => 'required|string|max:255',
            'correo_creacion' => 'required|email|max:255',
            'nombreEncargado_creacion' => 'required|string|max:255',
            'descripcion_creacion' => 'required|string|max:1000',
            'barrio_localidad_creacion' => 'required|string|max:255',
            'empresaFactura_creacion' => 'required|string|max:255',

        ], [
            'nombreLegal_creacion.required' => 'El nombre legal es obligatorio.',
            'nombreComercial_creacion.required' => 'El nombre comercial es obligatorio.',
            'grupo_creacion.required' => 'El grupo es obligatorio.',
            'telefono_creacion.required' => 'El teléfono es obligatorio.',
            'telefono_creacion.integer' => 'El teléfono debe ser númerico.',
            'nit_creacion.required' => 'El NIT es obligatorio.',
            'telefono_creacion.unique' => 'El número de celular ya está registrado.',
            'iddepartamento_creacion.required' => 'El departamento es obligatorio.',
            'idciudad_creacion.required' => 'La ciudad es obligatoria.',
            'correo_creacion.required' => 'El correo electrónico es obligatorio.',
            'correo_creacion.email' => 'El correo debe ser una dirección de email válida.',
            'direccion_creacion.required' => 'La dirección es obligatoria.',
            'sucursal_creacion.required' => 'La sucursal es obligatoria.',
            'nombreEncargado_creacion.required' => 'El nombre del encargado es obligatorio.',
            'descripcion_creacion.required' => 'La descripción es obligatoria.',
            'empresaFactura_creacion.required' => 'No seleccionó con que empresa factura.',
            'barrio_localidad_creacion.required' => 'El barrio o localidad es obligatorio.',
        ]);
    }

    public function crearProveedor()
    {
        $this->validacionCamposCreacionProveedor();

        $proveedor = ProveedoresModel::create([
            'telefono' => $this->telefono_creacion,
            'grupo' => $this->grupo_creacion,
            'nombre_comercial' => $this->nombreComercial_creacion,
            'nombre_legal' => $this->nombreLegal_creacion,
            'nit' => $this->nit_creacion,
            'sucursal' => $this->sucursal_creacion,
            'barrio_localidad' => $this->barrio_localidad_creacion,
            'direccion' => $this->direccion_creacion,
            'ciudad' => $this->idciudad_creacion,
            'departamento' => $this->iddepartamento_creacion,
            'correo' => $this->correo_creacion,
            'nombre_encargado' => $this->nombreEncargado_creacion,
            'descripcion' => $this->descripcion_creacion,
            'empresa_factura' => $this->empresaFactura_creacion,
            'estado' => 1,
            'registrado_por' => Auth::user()->id,
        ]);

        if ($proveedor) {

            $this->orden->datos = $proveedor;
            $this->orden->datos->empresa_factura = $this->empresaFactura_creacion;
            $empresa_factura = EmpresasModel::find($this->empresaFactura_creacion);
            $this->orden->datos_empresa = json_encode($empresa_factura);
            $this->orden->save();
            //Actualizar la información de la empresa factura según la empresa seleccionada
            $this->empresa_factura = $empresa_factura;

            $this->datos = json_decode($this->orden->datos);

            $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();
            $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

            // Actualizar los datos
            $this->telefono_edicion = $this->datos->telefono;
            $this->nombreComercial_edicion = $this->datos->nombre_comercial;
            $this->grupo_edicion = $this->datos->grupo;
            $this->nombreLegal_edicion = $this->datos->nombre_legal;
            $this->nit_edicion = $this->datos->nit;
            $this->sucursal_edicion = $this->datos->sucursal;
            $this->direccion_edicion = $this->datos->direccion;
            $this->barrio_localidad_edicion = $this->datos->barrio_localidad;
            $this->idciudad_edicion = $this->datos->ciudad;
            $this->ciudad_edicion = $this->ciudad->nombre_municipio;
            $this->iddepartamento_edicion = $this->datos->departamento;
            $this->departamento_edicion = $this->departamento->nombre_departamento;
            $this->correo_edicion = $this->datos->correo;
            $this->nombreEncargado_edicion = $this->datos->nombre_encargado;
            $this->empresaFactura_edicion = $this->datos->empresa_factura;
            $this->descripcion_edicion = $this->datos->descripcion;


            $this->dispatch('datos-actualizados', [
                'datos' => $this->datos,
                'ciudad' => $this->ciudad->nombre_municipio,
                'departamento' => $this->departamento->nombre_departamento
            ]);

            $this->dispatch('limpiar-campos-creacion');
        }
    }

    public function reinicializarDatosCreacionProveedor()
    {
        $this->telefono_creacion = null;
        $this->grupo_creacion = null;
        $this->nombreLegal_creacion = null;
        $this->nombreComercial_creacion = null;
        $this->nit_creacion = null;
        $this->sucursal_creacion = null;
        $this->direccion_creacion = null;
        $this->barrio_localidad_creacion = null;
        $this->ciudad_creacion = null;
        $this->idciudad_creacion = null;
        $this->departamento_creacion = null;
        $this->iddepartamento_creacion = null;
        $this->correo_creacion = null;
        $this->nombreEncargado_creacion = null;
        $this->descripcion_creacion = null;
        $this->empresaFactura_creacion = null;
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

    public function render()
    {
        return view('livewire.general.ordenes.egreso');
    }
}
