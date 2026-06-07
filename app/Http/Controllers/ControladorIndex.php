<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nivel;
use App\Models\Profesor;
use App\Models\Rol;
use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ControladorIndex extends Controller
{

    // Página de inicio
    function Home()
    {
        return view('Portada');
    }
    // Página de eventos
    function Eventos()
    {
        return view('Eventos');
    }
    // Página de recursos
    function Recursos()
    {
        return view('Recursos');
    }
    // Página de formulario de contacto
    function Informate()
    {
        return view('Informate');
    }
    // Página para el gestor general
    function VistaGestor()
    {
        return view('Gestor');
    }

    // Formulario para añadir un profesor
    function AnadirProfesor()
    {
        $niveles = Nivel::all();

        return view('AnadirProfesor', [
            'niveles' => $niveles,
        ]);
    }
    // Formulario para añadir un alumno manualmente
    function AnadirAlumno()
    {

        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('AnadirAlumno', [
            'niveles' => $niveles,
            'profesores' => $profesores
        ]);
    }
    // Formulario web para añadir un alumno
    function WebAnadirAlumno()
    {

        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('WebAnadirAlumno', [
            'niveles' => $niveles,
            'profesores' => $profesores
        ]);
    }
    // Formulario para añadir un usuario con rol
    function AnadirUsuario()
    {
        $roles = Rol::all();
        return view('AnadirUsuario', [
            'roles' => $roles
        ]);
    }
    // Formulario de registro que incluye roles
    function LoginAnadirUsuario()
    {
        $roles = Rol::all();
        return view('LoginAnadirUsuario', [
            'roles' => $roles
        ]);
    }

    // Vista para gestionar profesores
    function GestionarProfesor()
    {
        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('GestionarProfesor', [
            'profesores' => $profesores,
            'niveles' => $niveles
        ]);
    }
    // Vista para gestionar alumnos
    function GestionarAlumno()
    {
        $alumnos = Alumno::all();
        return view('GestionarAlumno', ['alumnos' => $alumnos]);
    }
    // Vista para gestionar usuarios
    function GestionarUsuario()
    {
        $usuario = (new Usuario())->obtenerUsuario();
        return view('GestionarUsuario', ['usuario' => $usuario]);
    }

    // Página de login
    function VistaLogin()
    {
        return view('Login');
    }

    // PERFIL PARA PROFESOR Y ALUMNO
    // Muestra el perfil del usuario autenticado según su rol
    public function VistaPerfil()
    {
        $user = Auth::user();
        $perfil = null;

        if ($user->idrol == 3) {
            $perfil = Alumno::with(['profe', 'nivel'])
                ->where('usuario', $user->usuario)
                ->first();
        } elseif ($user->idrol == 2) {
            $perfil = Profesor::with('nivel')
                ->where('usuario_prof', $user->usuario)
                ->first();
        }

        if (!$perfil) {
            return redirect('/')->with('error', 'No se encontró el perfil asociado a este usuario o no tienes permiso para acceder.');
        }

        return view('perfil', compact('perfil'));
    }

    // LOGIN

    // Autentica al usuario con usuario/password
    function Autenticarse(Request $request)
    {

        $credenciales = $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', '¡Bienvenido a CoffeeTime!');
        } else {
            return redirect('/login')->with('error', 'Las credenciales no son correctas.');
        }
    }

    // LOGOUT
    // Cierra la sesión y desconecta al usuario
    public function CerrarSesion()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
