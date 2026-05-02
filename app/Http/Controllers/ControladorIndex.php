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

function Home(){
    return view('Portada');
}
function Eventos(){
    return view('Eventos');
}
function Recursos(){
    return view('Recursos');
}
function Informate(){
    return view('Informate');
}

function VistaGestor(){
    return view('Gestor');
}

function AñadirProfesor(){
    return view('AñadirProfesor');
}
function AñadirAlumno(){

        $niveles = Nivel::all();
        $profesores = Profesor::all();
        return view('AñadirAlumno', [
            'niveles' => $niveles,
            'profesores' => $profesores
        ]); 
    
    }
function AñadirUsuario(){
        $roles = Rol::all();
        return view('AñadirUsuario', [
            'roles' => $roles]); 
}
function LoginAñadirUsuario(){
    $roles = Rol::all();
    return view('LoginAñadirUsuario', [
        'roles' => $roles]); 
}

function GestionarProfesor(){
    $profesores = Profesor::all();
    return view('GestionarProfesor', ['profesores'=>$profesores]);
}
function GestionarAlumno(){
    $alumnos = Alumno::all();
    return view('GestionarAlumno' , ['alumnos'=>$alumnos]);
}
function GestionarUsuario(){
    $usuario = (new Usuario())->obtenerUsuario();
    return view('GestionarUsuario', ['usuario'=>$usuario]);
}

function VistaLogin(){
    return view('login');

}

//LOGIN

function Autenticarse(Request $request){

        $credenciales=$request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

    if(Auth::attempt($credenciales)){
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Bienvenido al SISTEMA de GESTIÓN.');
    }else{
        return redirect('/login')->with('error', 'Las credenciales no son correctas.');
    }
}

//LOGOUT
public function CerrarSesion() {
    Session::flush();
    Auth::logout();

    return redirect('/login');
}

}   



