<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControladorProfesor extends Controller
{

    public function RegistroProfesor(Request $request)
    {

        $profesor = new Profesor();

        $profesor->nombre_profesor = $request->nombre_profesor;
        $profesor->apellidos_profesor = $request->apellidos_profesor;
        $profesor->email_profesor = $request->email_profesor;
        $profesor->dni_profesor = $request->dni_profesor;
        $profesor->usuario_prof = $request->usuario_prof;
        $profesor->contraseña_prof = $request->contraseña_prof;
        $profesor->idrol =2; 

        $profesor->save();

        return redirect('agregarprofesor')->with('success', 'Profesor registrado correctamente.');
    }
    
    
    //CRUD


    public function consultar($id)
    {
        $profesor = (new Profesor())->obtenerProfesor($id); 
        $alumnonivel = (new Alumno())->obtenerProfesordeAlumno($id);

        return view('consultarprofesor', compact('profesor','alumnonivel')); 
    }

    public function editar($id)
    {
        $profesor = Profesor::find($id);

        return view('editarprofesor', [
            'profesor' => $profesor
        ]);
    }

    public function actualizar($id, Request $request)
    {

        $profesor = Profesor::find($id);
        $profesor->nombre_profesor = $request->nombre_profesor;
        $profesor->apellidos_profesor = $request->apellidos_profesor;
        $profesor->email_profesor = $request->email_profesor;
        $profesor->dni_profesor = $request->dni_profesor;
        $profesor->usuario_prof = $request->usuario_prof;
        $profesor->contraseña_prof = Hash::make($request->contraseña_prof);
        $profesor->idrol =2; 

        $profesor->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profesor actualizado correctamente.',
            'profesor' => $profesor,
        ]);
    }

    public function eliminarData($id) {
        $profesor = Profesor::where('id',$id)->first();
        $profesor->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Profesor borrado correctamente'
        ]);
    }


    public function mostrarData() {
        $profesor = Profesor::all();

        return view('gestionarprofesor', [
            'profesor' => $profesor         
        ]);
    }
    
    public function consultarData($id){

        $profesor = (new Profesor())->obtenerProfesor($id);

        return view('consultarprofesor', compact('profesor')); 

    }

    public function recargar() {
        $profesor = Profesor::all(); 

        return response()->json([
            'status' => 200,
            'profesor' => $profesor,
        ]);
    }


}
