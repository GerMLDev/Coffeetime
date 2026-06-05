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

    function Home()
    {
        return view('Portada');
    }
    function Eventos()
    {
        return view('Eventos');
    }
    function Recursos()
    {
        return view('Recursos');
    }
    function Informate()
    {
        return view('Informate');
    }
    function VistaGestor()
    {
        return view('Gestor');
    }

    function AnadirProfesor()
    {
        $niveles = Nivel::all();

        return view('AnadirProfesor', [
            'niveles' => $niveles,
        ]);
    }
    function AnadirAlumno()
    {

        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('AnadirAlumno', [
            'niveles' => $niveles,
            'profesores' => $profesores
        ]);
    }
    function WebAnadirAlumno()
    {

        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('WebAnadirAlumno', [
            'niveles' => $niveles,
            'profesores' => $profesores
        ]);
    }
    function AnadirUsuario()
    {
        $roles = Rol::all();
        return view('AnadirUsuario', [
            'roles' => $roles
        ]);
    }
    function LoginAnadirUsuario()
    {
        $roles = Rol::all();
        return view('LoginAnadirUsuario', [
            'roles' => $roles
        ]);
    }

    function GestionarProfesor()
    {
        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('GestionarProfesor', [
            'profesores' => $profesores,
            'niveles' => $niveles
        ]);
    }
    function GestionarAlumno()
    {
        $alumnos = Alumno::all();
        return view('GestionarAlumno', ['alumnos' => $alumnos]);
    }
    function GestionarUsuario()
    {
        $usuario = (new Usuario())->obtenerUsuario();
        return view('GestionarUsuario', ['usuario' => $usuario]);
    }

    function VistaLogin()
    {
        return view('Login');
    }

    //PERFILES PARA PROFESOR Y ALUMNO
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
        return redirect('/')->with('error', 'No se encontró el perfil asociado a este usuario.');
    }

    return view('perfil', compact('perfil'));
}

    //LOGIN

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

    //LOGOUT
    public function CerrarSesion()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
