<?php

namespace App\Livewire\Administracion\Usuarios;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class RegistrarUsuarios extends Component
{
    use WithFileUploads;

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

    public function render()
    {
        return view('livewire.administracion.usuarios.registrar-usuarios');
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'image' // Validar la imagen
        ], [
            'imagen.image' => 'El archivo debe ser una imagen.',
        ]);
    }

    public function registrarUsuario()
    {
        $this->validacionCampos();

        $rutaImagen = "";
        if ($this->imagen) {
            // Cambiamos el nombre de la imagen
            $extension = $this->imagen->extension();
            $nombreArchivo = $this->cedula . "." . $extension;
            $rutaImagen = $this->imagen->storeAs('imagenes/usuarios', $nombreArchivo);
        }

        $usuario = User::create(
            [
                'name' => $this->name,
                'apellidos' => $this->apellidos,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'cedula' => $this->cedula,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'correo' => $this->correo,
                'fecha_inicio' => $this->fecha_inicio,
                'referencia_1' => $this->referencia_1,
                'referencia_2' => $this->referencia_2,
                'horario' => $this->horario,
                'eps' => $this->eps,
                'pension' => $this->pension,
                'banco' => $this->banco,
                'numero_cuenta' => $this->numero_cuenta,
                'cargo' => $this->cargo,
                'perfil' => $this->perfil,
                'caja' => $this->caja,
                'imagen' => "$rutaImagen",
                'estado' => $this->estado
            ]
        );

        if ($usuario) {

            $role = Role::find($usuario->perfil);

            if ($role) {
                $usuario->assignRole($role);
                $message = "El usuario se ha registrado.";
                $this->dispatch('estadoActualizacion', title: "Registrado", icon: 'success', message: $message);
            } else {
                // Manejar el caso en el que el rol no exista
                throw new Exception('El rol especificado no existe.');
            }
        } else {
            $message = "El producto NO se ha registrado correctamente.";
            $this->dispatch('estadoActualizacion', title: "Error", icon: 'error', message: $message);
        }
    }

    public function cambioImagen()
    {
        $this->imagen = null;
    }

    public function validarCedulaUsuario()
    {
        $validarCedula = User::where('cedula', $this->cedula)->exists();

        if ($validarCedula) {
            $this->cedula = null;
            $message = "El número de cédula ya está registrado";
            $elementId = "cedula";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        }
    }

    public function validarUserName()
    {
        $validarUsername = User::where('username', trim($this->username))->exists();

        if ($validarUsername) {
            $this->username = null;
            $message = "El nombre de usuario de sistema ya está registrado";
            $elementId = "username";
            $this->dispatch('estadoCampos', message: $message, elementId: $elementId);
        }
    }

    public function validacionCampos()
    {
        return $this->validate(

            [
                'cedula' => 'required|unique:users,cedula', /*  */
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
                'username' => 'required|unique:users,username',
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

    #[On('redirigir')]
    public function redirgir()
    {
        return redirect()->route('admin-usuarios');
    }
}
