<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Alumno;
use App\Models\Nivel;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorRecurso extends Controller
{
    // Muestra la página de recursos con profes y niveles
    public function mostrarData()
    {
        $profesores = Profesor::all();
        $niveles    = Nivel::all();
        return view('recursos', compact('profesores', 'niveles'));
    }
    // Recarga recursos y filtra por nivel si es alumno
    public function recargar()
    {
        $user = Auth::user();
        $query = Recurso::with(['profesor', 'nivel']);

        if ($user && $user->idrol == 3) { // alumno
            $alumno = Alumno::where('usuario', $user->usuario)->first();
            if ($alumno) {
                // Solo ver recursos del mismo nivel que el alumno
                $query->where('idnivel', $alumno->idnivel);
            }
        }
    //Mapea los datos de los recursos y los envía a la tabla
        $recursos = $query->get()->map(function ($recurso) {
            return [
                'id'              => $recurso->id,
                'titulo'          => $recurso->titulo,
                'tipo'            => $recurso->tipo,
                'enlace'          => $recurso->enlace,
                'nivel'           => $recurso->nivel->nivel ?? '-',
                'nombre_profesor' => $recurso->profesor->nombre_profesor ?? '-',
            ];
        })->values();

        return response()->json([
            'status'   => 200,
            'recursos' => $recursos,
        ]);
    }

    // Registra un nuevo recurso y asigna el profe correcto
    public function registrar(Request $request)
    {
        $user = Auth::user();

        $validaciones = [
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'enlace' => 'required|string|max:2048',
            'idnivel' => 'required|integer|exists:nivel,id',
        ];

        if ($user && $user->idrol == 1) {
            $validaciones['idprofesor'] = 'required|integer|exists:profesor,id';
        }

        $request->validate($validaciones);

        $recurso = new Recurso();
        $recurso->titulo   = $request->titulo;
        $recurso->tipo     = $request->tipo;
        $recurso->enlace   = $request->enlace;
        $recurso->idnivel  = $request->idnivel;

        if ($user->idrol == 1) {
            // Si es admin, usa el profe elegido por el formulario
            $recurso->idprofesor = $request->idprofesor;
        } else {
            // Si no es admin, asigna al profe vinculado al usuario actual
            $profesor = Profesor::where('idusuario', $user->id)->first();
            $recurso->idprofesor = $profesor->id;
        }

        $recurso->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Recurso añadido correctamente.',
        ]);
    }

    // Elimina un recurso por su id
    public function eliminarData($id)
    {
        $recurso = Recurso::where('id', $id)->first();
        $recurso->delete();

        return response()->json([
            'status'  => 200,
            'mensaje' => 'Recurso eliminado correctamente.',
        ]);
    }
}
