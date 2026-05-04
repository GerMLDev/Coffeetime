<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Nivel;
use App\Models\Profesor;
use App\Models\Alumno;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorEvento extends Controller
{
    public function recargar()
    {
        $user = Auth::user();
        $alumnoId = null;

        if ($user && $user->idrol == 3) { // es alumno
            $alumno = Alumno::where('usuario', $user->usuario)->first();
            $alumnoId = $alumno ? $alumno->id : null;
        }

        $eventos = Evento::with(['nivel', 'profesor'])->get()->map(function ($evento) use ($alumnoId) {
            $inscrito = false;
            if ($alumnoId) {
                $inscrito = Inscripcion::where('idalumno', $alumnoId)
                    ->where('idevento', $evento->id)
                    ->exists();
            }

            return [
                'id'             => $evento->id,
                'titulo'         => $evento->titulo,
                'fecha'          => $evento->fecha,
                'hora'           => $evento->hora,
                'enlace'         => $evento->enlace,
                'nivel'          => $evento->nivel->nivel ?? '-',
                'nombre_profesor' => $evento->profesor->nombre_profesor ?? '-',
                'inscrito'       => $inscrito,
            ];
        });

        return response()->json([
            'status' => 200,
            'eventos' => $eventos,
        ]);
    }

    public function registrar(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'status'  => 401,
                'message' => 'No autenticado.',
            ], 401);
        }

        $evento = new Evento();
        $evento->titulo     = $request->titulo;
        $evento->fecha      = $request->fecha;
        $evento->hora       = $request->hora;
        $evento->enlace     = $request->enlace;
        $evento->idnivel    = $request->idnivel;

        if ($user->idrol == 1) { // admin
            $evento->idprofesor = $request->idprofesor;
        } else { // profesor
            $profesor = Profesor::where('idusuario', $user->id)->first();
            if (! $profesor) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No existe un profesor vinculado al usuario autenticado.',
                ], 422);
            }

            $evento->idprofesor = $profesor->id;
        }

        $evento->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Evento creado correctamente.',
            'evento'  => $evento,
        ]);
    }

    public function mostrarData()
    {
        $niveles    = Nivel::all();
        $profesores = Profesor::all();
        return view('eventos', compact('niveles', 'profesores'));
    }

    public function eliminarData($id)
    {
        $evento = Evento::where('id', $id)->first();
        $evento->delete();

        return response()->json([
            'status'  => 200,
            'mensaje' => 'Evento eliminado correctamente.',
        ]);
    }

    public function inscribir(Request $request, $id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'status'  => 401,
                'message' => 'No autenticado.',
            ], 401);
        }

        $alumno = Alumno::where('idusuario', $user->id)->first();
        if (! $alumno) {
            return response()->json([
                'status'  => 422,
                'message' => 'No existe un alumno vinculado al usuario autenticado.',
            ], 422);
        }

        $evento = Evento::find($id);
        if (! $evento) {
            return response()->json([
                'status'  => 404,
                'message' => 'Evento no encontrado.',
            ], 404);
        }

        $inscripcionExistente = Inscripcion::where('idalumno', $alumno->id)
            ->where('idevento', $evento->id)
            ->first();

        if ($inscripcionExistente) {
            return response()->json([
                'status'  => 422,
                'message' => 'Ya estás inscrito en este evento.',
            ], 422);
        }

        Inscripcion::create([
            'idalumno' => $alumno->id,
            'idevento' => $evento->id,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => 'Inscripción realizada correctamente.',
        ]);
    }

    public function cancelarInscripcion($id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'status'  => 401,
                'message' => 'No autenticado.',
            ], 401);
        }

        $alumno = Alumno::where('usuario', $user->usuario)->first();
        if (! $alumno) {
            return response()->json([
                'status'  => 422,
                'message' => 'No existe un alumno vinculado al usuario autenticado.',
            ], 422);
        }

        $inscripcion = Inscripcion::where('idalumno', $alumno->id)
            ->where('idevento', $id)
            ->first();

        if (! $inscripcion) {
            return response()->json([
                'status'  => 404,
                'message' => 'Inscripción no encontrada.',
            ], 404);
        }

        $inscripcion->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Inscripción cancelada correctamente.',
        ]);
    }
}
