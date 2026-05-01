<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Nivel;
use Illuminate\Support\Facades\Hash;

class ControladorAlumno extends Controller
{
    function obtenerAlumnos()
    {
        $alumnos = Alumno::all();

        return view('GestionarAlumno', [

            'alumnos' => $alumnos

        ]);
    }
    public function RegistroAlumnoLogin(Request $request)
    {

        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->email = $request->email;
        $alumno->dni = $request->dni;
        $alumno->usuario = $request->usuario;
        $alumno->contraseña = $request->contraseña;
        $alumno->idnivel = $request->idnivel;
        $alumno->idprofesor = $request->idprofesor;
        $alumno->idrol = 3;

        //POR DEFECTO sería el IDRol de usuario de ALUMNO (3) para que pueda registrarse pero no pueda acceder a la gestión de usuarios.

        $alumno->save();

        return redirect('/login')->with('success', 'Usuario registrado correctamente.');
    }
    public function RegistroAlumno(Request $request)
    {

        $alumno = new Alumno();

        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->email = $request->email;
        $alumno->dni = $request->dni;
        $alumno->usuario = $request->usuario;
        $alumno->contraseña = $request->contraseña;
        $alumno->idnivel = $request->idnivel;
        $alumno->idprofesor = $request->idprofesor;
        $alumno->idrol = 3;

        $alumno->save();

        return redirect('agregaralumno')->with('success', 'Alumno registrado correctamente.');
    }

    //CRUD

    public function consultar($id)
    {

        $alumno = (new Alumno())->obtenerAlumno($id);

        return view('consultaralumno', compact('alumno'));
    }

    public function editar($id)
    {
        $alumno = Alumno::findOrFail($id);
        $niveles = Nivel::all();
        $profesores = Profesor::all();

        return response()->json([
            'status' => 200,
            'alumno' => $alumno,
            'niveles' => $niveles,
            'profesores' => $profesores
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->email = $request->email;
        $alumno->dni = $request->dni;
        $alumno->usuario = $request->usuario;
        $alumno->contraseña = Hash::make($request->contraseña);
        $alumno->idnivel = $request->nivel;
        $alumno->idprofesor = $request->profesor;
        $alumno->idrol =3; 

        $alumno->save();

        return response()->json([
            'status' => 200,
            'message' => 'Alumno actualizado correctamente',
            'alumno' => $alumno,
        ]);
    }



    public function mostrarData()
    {
        $alumno = Alumno::all();

        return view('gestionaralumno', [
            'alumno' => $alumno
        ]);
    }

    // public function consultarData($id){

    //     $alumno = (new Alumno())->obtenerAlumno($id);

    //     return view('consultaralumno', compact('alumno')); 

    // }
    public function eliminarData($id)
    {
        $alumno = Alumno::where('id', $id)->first();

        $alumno->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Alumno borrado correctamente'
        ]);
    }



    public function recargar()
    {
        //Recupera el profe de alumno y el nivel
        $alumno = Alumno::with(['profe', 'nivel'])->get();
        return response()->json([
            'status' => 200,
            'alumno' => $alumno,
        ]);
    }


    public function dashboardNivel()
    {
        $datos = (new Alumno())->getAlumnosPorNivel();

        return view('dashboard', [
            'datos' => $datos
        ]);
    }

    public function dashboardProfesor()
    {
        $datos = (new Alumno())->getAlumnosPorProfesor();

        return view('dashboardProfe', [
            'datos' => $datos
        ]);
    }
}
