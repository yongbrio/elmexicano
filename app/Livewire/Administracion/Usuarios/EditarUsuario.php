<?php

namespace App\Livewire\Administracion\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class EditarUsuario extends Component
{
    use WithFileUploads;

    public $id;
    public $cedula;
    public $name;
    public $apellidos;
    public $fecha_nacimiento;
    public $direccion;
    public $telefono;
    public $correo;
    public $fecha_inicio;
    public $referencia_1;
    public $referencia_2;
    public $horario;
    public $username;
    public $eps;
    public $pension;
    public $banco;
    public $numero_cuenta;
    public $cargo;
    public $password;
    public $password_confirmation;
    public $perfil;
    public $caja;
    public $estado;
    #[Validate('image')]
    public $imagen;
    public $imagen_db;


    public function mount($id)
    {
        $this->id = $id;

        $usuario = User::find($this->id);

        if ($usuario) {

            $this->cedula = $usuario->cedula;
            $this->name = $usuario->name;
            $this->apellidos = $usuario->apellidos;
            $this->fecha_nacimiento = $usuario->fecha_nacimiento;
            $this->direccion = $usuario->direccion;
            $this->telefono = $usuario->telefono;
            $this->correo = $usuario->correo;
            $this->fecha_inicio = $usuario->fecha_inicio;
            $this->referencia_1 = $usuario->referencia_1;
            $this->referencia_2 = $usuario->referencia_2;
            $this->horario = $usuario->horario;
            $this->username = $usuario->username;
            $this->eps = $usuario->eps;
            $this->pension = $usuario->pension;
            $this->banco = $usuario->banco;
            $this->numero_cuenta = $usuario->numero_cuenta;
            $this->imagen_db = $usuario->imagen;
            $this->cargo = $usuario->cargo;
            $this->perfil = $usuario->perfil;
            $this->caja = $usuario->caja;
            $this->estado = $usuario->estado;
        } else {

            $this->redirgir();
        }
    }

    public function render()
    {
        return view('livewire.administracion.usuarios.editar-usuario');
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'image' // Validar la imagen
        ], [
            'imagen.image' => 'El archivo debe ser una imagen.',
        ]);
    }

    public function actualizarUsuario()
    {
        $this->validacionCampos();

        $rutaImagen = "";
        if ($this->imagen) {
            // Cambiamos el nombre de la imagen
            $extension = $this->imagen->extension();
            $nombreArchivo = $this->cedula . "." . $extension;
            $rutaImagen = $this->imagen->storeAs('imagenes/usuarios', $nombreArchivo);
        }

        $usuario = User::find($this->id);

        if ($usuario) {
            $usuario->name = $this->name;
            $usuario->apellidos = $this->apellidos;
            $usuario->username = $this->username;
            $usuario->password = Hash::make($this->password);
            $usuario->cedula = $this->cedula;
            $usuario->fecha_nacimiento = $this->fecha_nacimiento;
            $usuario->direccion = $this->direccion;
            $usuario->telefono = $this->telefono;
            $usuario->correo = $this->correo;
            $usuario->fecha_inicio = $this->fecha_inicio;
            $usuario->referencia_1 = $this->referencia_1;
            $usuario->referencia_2 = $this->referencia_2;
            $usuario->horario = $this->horario;
            $usuario->eps = $this->eps;
            $usuario->pension = $this->pension;
            $usuario->banco = $this->banco;
            $usuario->numero_cuenta = $this->numero_cuenta;
            $usuario->cargo = $this->cargo;
            $usuario->password = $this->password;
            $usuario->perfil = $this->perfil;
            $usuario->caja = $this->caja;
            if (!$this->imagen_db && $this->imagen) {
                $usuario->imagen = "$rutaImagen";
            } else if (!$this->imagen_db && !$this->imagen) {
                $usuario->imagen = "$rutaImagen";
            }
            $usuario->estado = $this->estado;
        }

        $actualizarUsuario = $usuario->save();

        if ($actualizarUsuario) {
            $role = Role::find($usuario->perfil);
            $usuario->assignRole($role);
            $message = "El usuario se ha actualizado.";
            $this->dispatch('estadoActualizacion', title: "Actualizado", icon: 'success', message: $message);
        } else {
            $message = "El producto NO se ha actualizado correctamente.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        }
    }

    public function validacionCampos()
    {
        return $this->validate(

            [
                'cedula' => 'required|unique:users,cedula,' . $this->id,
                'name' => ['required', 'string', 'regex:/^[^0-9]*$/'],
                'apellidos' => ['required', 'string', 'regex:/^[^0-9]*$/'],
                'telefono' => ['required', 'regex:/^[\d\s\-\+\(\)]+$/'],
                'fecha_nacimiento' => ['required', 'date', 'before_or_equal:today'],
                'direccion' => 'required',
                'correo' => 'required|email',
                'fecha_inicio' => ['required', 'date'],
                'referencia_1' => 'required',
                'referencia_2' => 'required',
                'horario' => 'required',
                'username' => 'required|unique:users,username,' . $this->id,
                'eps' => 'required',
                'pension' => 'required',
                'banco' => 'required',
                'numero_cuenta' => 'required',
                'cargo' => 'required',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => 'required',
                'perfil' => 'required',
                'caja' => 'required',
                'estado' => 'required',

            ],
            [
                'cedula.required' => 'El número de cédula es requerido',
                'cedula.unique' => 'El número de cédula ya está registrado',
                'name.required' => 'El nombre del usuario son requeridos',
                'name.regex' => 'El nombre del usuario no debe contener números',
                'apellidos.required' => 'El apellido del usuario es requerido',
                'apellidos.regex' => 'El apellido del usuario no debe contener números',
                'telefono.required' => 'El número de teléfono es requerido',
                'telefono.regex' => 'El formato del teléfono no es valido',
                'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',
                'fecha_nacimiento.date' => 'La fecha de nacimiento no tiene un formato valido',
                'fecha_nacimiento.before_or_equal' => 'La fecha no puede ser mayor a la actual',
                'direccion.required' => 'La dirección es requerida',
                'correo.required' => 'El correo es requerido',
                'correo.email' => 'El formato del correo no es valido>',
                'fecha_inicio.required' => 'La fecha de inicio es requerida',
                'fecha_inicio.date' => 'La fecha de inicio no tiene un formato valido',
                'referencia_1.required' => 'La referencia 1 es requerida',
                'referencia_2.required' => 'La referencia 2 es requerida',
                'horario.required' => 'El horario es requerido',
                'username.required' => 'El usuario es requerido',
                'username.unique' => 'El usuario ya existe',
                'eps.required' => 'La EPS es requerida',
                'pension.required' => 'La pensión es requerida',
                'banco.required' => 'El banco es requerido',
                'numero_cuenta.required' => 'El número de cuenta es requerido',
                'cargo.required' =>  'El cargo es requerido',
                'password.required' => 'La contraseña es requerida',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'La contraseña no coincide con la verificación',
                'password_confirmation.required' => 'La confirmación de la contraseña es requerida',
                'perfil.required' => 'El perfil es requerido',
                'caja.required' => 'La caja es requerida',
                'estado.required' => 'El estado es requerido',
            ]
        );
    }

    public function cambioImagen()
    {
        $this->imagen = null;
    }

    public function eliminarImagen()
    {
        $this->imagen_db = null;
    }

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-usuarios');
    }

    public function cancelarActualizarUsuario()
    {
        return redirect()->route('admin-usuarios');
    }

    public function validarCedulaUsuario()
    {
        $validarCedula = User::where('cedula', $this->cedula)->where('id', '!=', $this->id)->exists();

        if ($validarCedula) {
            $this->cedula = null;
            $message = "El número de cédula ya está registrado";
            $elementId = "cedula";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        }
    }

    public function validarUserName()
    {
        $validarUsername = User::where('username', trim($this->username))->where('id', '!=', $this->id)->exists();

        if ($validarUsername) {
            $this->username = null;
            $message = "El nombre de usuario de sistema ya está registrado";
            $elementId = "username";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        }
    }
}
