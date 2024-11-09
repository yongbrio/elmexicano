<?php

namespace App\Livewire\General\Ordenes;

use App\Models\CuentasBancariasModel;
use App\Models\DepartamentosModel;
use App\Models\EmpresasModel;
use App\Models\InventarioModel;
use App\Models\MunicipiosModel;
use App\Models\OrdenesModel;
use App\Models\PagosOrdenes;
use App\Models\SucursalesModel;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Ingreso extends Component
{
    use WithFileUploads;

    public $id;

    public $orden;

    public $numero_orden;

    public $producto;

    public $precio_unitario_con_iva;

    public $precio_unitario_sin_iva;

    public $stock_disponible;

    public $datos;

    public $fecha;

    public $nombre_sucursal;

    public $stock_transferencia;

    public $comision;

    public $listaProductosAgregados = [];

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

    public $inventarioVisible = true;

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

    public function mount(int $id)
    {
        $this->id = $id;

        $this->fecha_pago = date('Y-m-d');

        $orden = OrdenesModel::where('id', $this->id)->where('tipo_orden', 'ingreso')->first();

        if ($orden) {

            $this->orden = $orden;

            if ($this->orden->estado_envio == 2 && !empty($this->orden->adjuntos_envios)) {
                $this->enviar_conciliar = true;
            }

            if ($this->orden->forma_pago !== '') {
                $this->inventarioVisible = false;
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

            $this->datos_cuentas_banco = CuentasBancariasModel::where('empresa', $this->datos->empresa_factura)->where('estado', 1)->get();

            $usuario = User::find($this->orden->registrado_por);

            $this->nombre_registrado_por = $usuario->name . " " . $usuario->apellidos;

            $this->historialComentarios = json_decode($this->orden->comentarios);

            $this->ciudad = MunicipiosModel::where('id', $this->datos->ciudad)->first();

            $this->departamento = DepartamentosModel::where('id', $this->datos->departamento)->first();

            $date = new DateTime($this->datos->created_at);

            $formattedDate = $date->format('Y-m-d H:i:s');

            $this->fecha = $formattedDate;

            $sucursal = SucursalesModel::find($this->orden->id_sucursal);

            $this->nombre_sucursal = $sucursal->nombre_sucursal;

            $this->empresa_factura = EmpresasModel::find($this->datos->empresa_factura);

            $this->empresa_factura = $this->empresa_factura->nombre_legal;

            // Verifica si $this->orden->detalle no está vacío y es una cadena
            if (!empty($this->orden->detalle) && is_string($this->orden->detalle)) {
                $decodedData = json_decode($this->orden->detalle, true);

                // Verifica si json_decode no produjo un error y devolvió un array válido
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedData)) {
                    $this->listaProductosAgregados = $decodedData;
                    foreach ($this->listaProductosAgregados as $pr) {
                        $this->valor_total_orden += $pr['total'];
                    }
                } else {
                    // Inicializa la variable en vacío si hay un error en la decodificación JSON
                    $this->listaProductosAgregados = [];
                }
            } else {
                // Inicializa la variable en vacío si los datos no son válidos o están vacíos
                $this->listaProductosAgregados = [];
            }
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

    public function validarStock()
    {
        // Remover espacios al inicio y al final
        $this->stock_transferencia = trim($this->stock_transferencia);

        // Verificar si el valor es un entero válido
        if (!ctype_digit($this->stock_transferencia)) {
            $message = "Ingrese un valor válido";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        // Convertir el valor a un entero
        /* $this->stock_transferencia = (int) $this->stock_transferencia; */

        // Verificar si el valor es mayor que el stock disponible
        if ($this->stock_transferencia > $this->stock_disponible) {
            $message = "La cantidad a agregar no puede ser mayor al disponible";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        // Verificar si el valor es menor o igual a cero
        if ($this->stock_transferencia <= 0) {
            $message = "El valor no puede ser cero o negativo";
            $elementId = 'stock_transferencia';
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
            $this->stock_transferencia = null;
            return false;
        }

        return true;
    }

    #[On('agregar')]
    public function agregar($id)
    {
        $this->producto = null;
        $this->precio_unitario_con_iva = null;
        $this->precio_unitario_sin_iva = null;
        $this->stock_disponible = null;
        $this->comision = null;
        $this->stock_transferencia = null;

        $producto = InventarioModel::find($id);

        if ($producto) {

            $this->producto = $producto;
            $this->precio_unitario_con_iva = $producto->precio_unitario_con_iva;
            $this->precio_unitario_sin_iva = $producto->precio_unitario_sin_iva;
            $this->stock_disponible = $producto->stock;
            $this->comision = $producto->comision;
        }
    }

    public function agregarListaProductos()
    {
        if ($this->validarStock()) {

            $imagen = $this->producto->imagen;

            $nuevoProducto = [
                'id_producto' => $this->producto->id,
                'imagen' => $imagen,
                'id_sucursal' => $this->producto->sucursal,
                'codigo_producto' => $this->producto->codigo_producto,
                'cantidad_producto' => $this->stock_transferencia,
                'precio_unitario_con_iva' => $this->producto->precio_unitario_con_iva,
                'precio_unitario_sin_iva' => $this->producto->precio_unitario_sin_iva,
                'comision' => $this->producto->comision,
                'valor_comision' => (($this->stock_transferencia * $this->producto->precio_unitario_con_iva) * $this->producto->comision) / 100,
                'descripcion' => $this->producto->descripcion,
                'total' => $this->stock_transferencia * $this->producto->precio_unitario_con_iva,
            ];

            $existe = false;

            // Iterar sobre la lista de productos agregados
            foreach ($this->listaProductosAgregados as &$producto) {
                if ($producto['id_producto'] === $nuevoProducto['id_producto']) {
                    if (($nuevoProducto['cantidad_producto']) > $this->stock_disponible) {
                        $message = "La cantidad total ingresada supera la cantidad disponible en stock";
                        $elementId = 'stock_transferencia';
                        $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
                        $this->stock_transferencia = null;
                        return; // Detener la ejecución del método
                    } else {
                        // Producto ya existe, actualizar cantidad y total
                        $producto['cantidad_producto'] += $nuevoProducto['cantidad_producto'];
                        $producto['total'] = $producto['cantidad_producto'] * $producto['precio_unitario_con_iva'];
                        $this->valor_total_orden = $producto['total'];
                        $producto['valor_comision'] = ($producto['total'] * $producto['comision']) / 100;

                        $this->producto->stock = ($this->producto->stock - $nuevoProducto['cantidad_producto']);
                        $this->producto->save();

                        /* $this->orden->detalle = json_encode($this->listaProductosAgregados); */
                        $detalle = json_decode(json_encode($this->listaProductosAgregados));

                        foreach ($detalle as $key => $val) {
                            if ($val->id_producto === $producto['id_producto']) {
                                $val->cantidad_producto = $producto['cantidad_producto'];
                                $val->total = $producto['total'];
                                $this->valor_total_orden = $val->total;
                            }
                        }

                        $this->orden->detalle = json_encode($detalle);

                        $this->orden->save();

                        $this->agregar($this->producto->id);

                        $existe = true;
                        $message = 'El producto se agregó a la lista';
                        $icon = 'success';
                        $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
                        $this->dispatch('recargarComponente');
                        break;
                    }
                }
            }

            // Si no se encontró el producto, agregarlo a la lista
            if (!$existe) {

                $this->producto->stock = ($this->producto->stock - $nuevoProducto['cantidad_producto']);
                $this->producto->save();
                $this->agregar($this->producto->id);

                $message = 'El producto se agregó a la lista';
                $icon = 'success';
                $this->dispatch('mensajes', message: $message, icon: $icon, state: true);
                $this->dispatch('recargarComponente');
                $this->listaProductosAgregados[] = $nuevoProducto;
                $this->valor_total_orden = $nuevoProducto['total'];
                $this->orden->detalle = json_encode($this->listaProductosAgregados);
                $this->orden->save();
            }
        }
    }

    public function modificarCantidadProducto(&$productos, $id_producto, $nueva_cantidad)
    {
        foreach ($productos as &$producto) {
            if ($producto['id_producto'] == $id_producto) {
                $producto['cantidad_producto'] = $nueva_cantidad;
                return true; // Producto encontrado y cantidad modificada
            }
        }
        return false; // Producto no encontrado
    }

    public function eliminarProductoLista($id)
    {    // Encuentra el producto que se va a eliminar para obtener su cantidad
        $cantidadProducto = 0;
        $this->listaProductosAgregados = array_filter($this->listaProductosAgregados, function ($producto) use ($id, &$cantidadProducto) {
            if ($producto['id_producto'] === $id) {
                $cantidadProducto = $producto['cantidad_producto']; // Obtén la cantidad del producto
                $this->valor_total_orden = $this->valor_total_orden - $producto['total'];
                return false; // Elimina el producto del array
            }
            return true; // Mantén el producto en el array
        });

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaProductosAgregados));
        $this->orden->save();

        // Actualiza la tabla con la cantidad del producto eliminado
        $this->actualizarInventario($id, $cantidadProducto);
    }

    public function disminuirProductoLista($id)
    {
        // Recorre los productos para disminuir en 1 la cantidad del producto con el ID especificado
        foreach ($this->listaProductosAgregados as &$producto) {
            if ($producto['id_producto'] === $id) {
                // Si la cantidad es mayor a 1, solo restamos 1
                if ($producto['cantidad_producto'] > 1) {
                    $producto['cantidad_producto']--;
                    $producto['total'] = $producto['total'] - $producto['precio_unitario_con_iva'];
                    $this->valor_total_orden = $this->valor_total_orden - $producto['precio_unitario_con_iva'];
                    $producto['valor_comision'] = $producto['valor_comision'] - ($producto['precio_unitario_con_iva'] * $producto['comision']) / 100;
                } else {
                    // Si la cantidad es 1, lo eliminamos de la lista
                    $this->listaProductosAgregados = array_filter($this->listaProductosAgregados, function ($prod) use ($id) {
                        return $prod['id_producto'] !== $id;
                    });
                }
                break;
            }
        }

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaProductosAgregados));
        $this->orden->save();

        // Actualiza la tabla con la disminución del producto
        $this->actualizarInventario($id, 1); // Disminuye 1 del inventario
    }

    public function aumentarProductoLista($id)
    {
        // Recorre la lista de productos para encontrar el producto con el ID especificado
        foreach ($this->listaProductosAgregados as &$producto) {
            if ($producto['id_producto'] === $id) {
                // Aumenta la cantidad del producto en 1
                $producto['cantidad_producto']++;
                $producto['total'] = $producto['total'] + $producto['precio_unitario_con_iva'];
                $this->valor_total_orden = $this->valor_total_orden + $producto['precio_unitario_con_iva'];
                $producto['valor_comision'] = $producto['valor_comision'] + ($producto['precio_unitario_con_iva'] * $producto['comision']) / 100;
                break;
            }
        }

        // Actualiza el detalle en la orden
        $this->orden->detalle = json_encode(array_values($this->listaProductosAgregados));
        $this->orden->save();

        // Actualiza el inventario con el incremento del producto
        $this->actualizarInventario($id, -1); // Aumentamos el producto, restando 1 del inventario
    }

    private function actualizarInventario($id, $cantidadProducto)
    {
        $inventario = InventarioModel::find($id);

        if ($inventario) {

            $inventario->stock = $inventario->stock + $cantidadProducto;
            $inventario->save();

            $this->dispatch('recargarComponente');
            $message = "";
            if ($cantidadProducto < 0) {
                $message = 'El producto se agregó a la lista';
            } else {
                $message = 'El producto se eliminó de la lista';
            }

            $icon = 'success';
            $this->dispatch('mensajes', message: $message, icon: $icon, state: false);
        }
    }

    public function updatedArchivosEnvio()
    {
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
        $archivo->storeAs('imagenes/ingresos', $nuevoNombre);

        // Crear un nuevo objeto para el archivo
        $nuevoElemento = new \stdClass();
        $nuevoElemento->id = $this->id_file;
        $nuevoElemento->nombre_original = $archivo->getClientOriginalName();
        $nuevoElemento->nombre = $nuevoNombre;
        $nuevoElemento->fecha = date('d-m-Y');
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
        $archivo->storeAs('imagenes/ingresos', $nuevoNombre);

        $archivos = $this->orden->adjuntos;
        //Insertar los valores en Pagos de Ordenes
        $pagosOrdenes = new PagosOrdenes();
        $pagosOrdenes->orden = $this->orden->id;
        $pagosOrdenes->fecha = strtotime($this->fecha_pago);
        $pagosOrdenes->id_empresa = $this->datos->empresa_factura;
        $pagosOrdenes->nombre_empresa = $this->empresa_factura;

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
                        $rutaArchivo = storage_path('app/imagenes/ingresos/' . $archivo->nombre);

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
        $rutaArchivo = storage_path('app/imagenes/ingresos/' . $this->adjuntos_envios->nombre);

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
            $this->inventarioVisible = false;
        } else {
            $this->inventarioVisible = true;
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
        $pagosOrdenes->nombre_empresa = $this->empresa_factura;
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

        $this->inventarioVisible = true;

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

    public function render()
    {
        return view('livewire.general.ordenes.ingreso');
    }
}
