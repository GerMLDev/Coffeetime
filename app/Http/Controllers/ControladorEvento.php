<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Nivel;
use App\Models\Profesor;
use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Http\Controllers\ControladorContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorEvento extends Controller
{
    public function recargar()
    {
        $user = Auth::user();
        $alumnoId = null;
        $alumnoProfesorId = null;
        $profesorId = null;

        $query = Evento::with(['nivel', 'profesor']);
//Filtro para alumnos
        if ($user && $user->idrol == 3) {
            $alumno = Alumno::where('usuario', $user->usuario)->first();

            if ($alumno) {
                $alumnoId = $alumno->id;
                $alumnoProfesorId = $alumno->idprofesor;
                $query->where('idprofesor', $alumnoProfesorId);
            } else {
                return response()->json([
                    'status'  => 200,
                    'eventos' => [],
                    'mensaje'  => 'No hay eventos disponibles para ti todavía.',
                ]);
            }
        }
//Filtro de profesores
        if ($user && $user->idrol == 2) {
            $profesor = Profesor::where('idusuario', $user->id)->first();
            if ($profesor) {
                $profesorId = $profesor->id;
                $query->where('idprofesor', $profesorId);
            }
        }

        $eventos = $query->get()->map(function ($evento) use ($alumnoId, $profesorId, $user) {
            $inscrito = false;
            if ($alumnoId) {
                $inscrito = Inscripcion::where('idalumno', $alumnoId)
                    ->where('idevento', $evento->id)
                    ->exists();
            }
//Si tiene permiso, elimina


            $puedeEliminar = false;
            $puedeVerInscritos = false;
            if ($user && $user->idrol == 1) {
                $puedeEliminar = true;
                $puedeVerInscritos = true;
            } elseif ($user && $user->idrol == 2 && $evento->idprofesor == $profesorId) {
                $puedeEliminar = true;
                $puedeVerInscritos = true;
            }

            return [
                'id'              => $evento->id,
                'titulo'          => $evento->titulo,
                'fecha'           => $evento->fecha,
                'hora'            => $evento->hora,
                'enlace'          => $evento->enlace,
                'nivel'           => $evento->nivel->nivel ?? '-',
                'nombre_profesor' => $evento->profesor->nombre_profesor ?? '-',
                'inscrito'        => $inscrito,
                'caducado'        => $evento->caducado,
                'estado'          => $evento->caducado ? 'Caducado' : 'Activo',
                'puede_eliminar'  => $puedeEliminar,
                'puede_ver_inscritos' => $puedeVerInscritos,
            ];
        });

        return response()->json([
            'status' => 200,
            'eventos' => $eventos,
        ]);
    }
//Registra evento
    public function registrar(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'status'  => 401,
                'message' => 'No autenticado.',
            ], 401);
        }

        $validaciones = [
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required|string|max:50',
            'enlace' => 'required|string|max:2048',
            'idnivel' => 'required|integer|exists:nivel,id',
        ];

        if ($user->idrol == 1) {
            $validaciones['idprofesor'] = 'required|integer|exists:profesor,id';
        }

        $request->validate($validaciones);
//Recupera el profesor logueado para el evento
        $profesor = $this->obtenerProfesorParaEvento($user, $request);
        if (! $profesor) {
            return response()->json([
                'status'  => 422,
                'message' => 'No existe un profesor vinculado al usuario autenticado.',
            ], 422);
        }

        $evento = new Evento();
        $evento->titulo = $request->titulo;
        $evento->fecha = $request->fecha;
        $evento->hora = $request->hora;
        $evento->enlace = $request->enlace;
        $evento->idnivel = $request->idnivel;
        $evento->idprofesor = $profesor->id;
        $evento->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Evento creado correctamente.',
            'evento'  => $evento,
        ]);
    }

    private function obtenerProfesorParaEvento($user, Request $request)
    {
        if ($user->idrol == 1) {
            return Profesor::find($request->idprofesor);
        }

        return Profesor::where('idusuario', $user->id)->first();
    }

    public function mostrarData()
    {
        $niveles    = Nivel::all();
        $profesores = Profesor::all();
        return view('eventos', compact('niveles', 'profesores'));
    }

    public function eliminarData($id)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['status' => 401, 'mensaje' => 'No autenticado.'], 401);
        }

        $evento = Evento::find($id);
        if (! $evento) {
            return response()->json(['status' => 404, 'mensaje' => 'Evento no encontrado.'], 404);
        }

        if ($user->idrol == 2) {
            $profesor = Profesor::where('idusuario', $user->id)->first();
            if (! $profesor || $evento->idprofesor != $profesor->id) {
                return response()->json(['status' => 403, 'mensaje' => 'No autorizado para eliminar este evento.'], 403);
            }
        }

        $evento->delete();

        return response()->json([
            'status'  => 200,
            'mensaje' => 'Evento eliminado correctamente.',
        ]);
    }

    public function inscribir(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'No autenticado.'], 401);
        }

        $alumno = Alumno::where('usuario', $user->usuario)->first();
        if (!$alumno) {
            return response()->json(['status' => 422, 'message' => 'No existe un alumno vinculado al usuario autenticado.'], 422);
        }

        $evento = Evento::with(['nivel', 'profesor'])->find($id);
        if (!$evento) {
            return response()->json(['status' => 404, 'message' => 'Evento no encontrado.'], 404);
        }

        Inscripcion::create([
            'idalumno' => $alumno->id,
            'idevento' => $evento->id,
        ]);

        // Email de confirmación
        $contacto = new ControladorContacto();
        $contacto->confirmarInscripcion(
            $alumno->nombre,
            $alumno->apellidos,
            $alumno->email,
            $evento->titulo,
            $evento->fecha,
            $evento->hora,
            $evento->enlace,
            $evento->nivel->nivel ?? '—',
            $evento->profesor->nombre_profesor ?? '—',
            $evento->profesor->apellidos_profesor ?? ''
        );

        return response()->json(['status' => 200, 'message' => 'Inscripción realizada correctamente.']);
    }


// Recuoerar inscripciones
    public function obtenerInscripciones($id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'status'  => 401,
                'message' => 'No autenticado.',
            ], 401);
        }

        $evento = Evento::with('profesor')->find($id);
        if (! $evento) {
            return response()->json([
                'status'  => 404,
                'message' => 'Evento no encontrado.',
            ], 404);
        }

        if ($user->idrol == 2) {
            $profesor = Profesor::where('idusuario', $user->id)->first();
            if (! $profesor || $evento->idprofesor != $profesor->id) {
                return response()->json([
                    'status'  => 403,
                    'message' => 'No autorizado para ver las inscripciones de este evento.',
                ], 403);
            }
        }

        $inscripciones = Inscripcion::where('idevento', $evento->id)
            ->with('alumno')
            ->get();

        $alumnos = $inscripciones->map(function ($inscripcion) {
            return [
                'nombre'   => $inscripcion->alumno->nombre ?? '',
                'apellidos' => $inscripcion->alumno->apellidos ?? '',
            ];
        });

        return response()->json([
            'status'       => 200,
            'evento'       => $evento->titulo,
            'inscripciones' => $alumnos,
        ]);
    }

    // Cancelar inscripción

    public function cancelarInscripcion($id){
    $user = Auth::user();

    if (!$user) {
        return response()->json(['status' => 401, 'message' => 'No autenticado.'], 401);
    }

    $alumno = Alumno::where('usuario', $user->usuario)->first();
    $inscripcion = Inscripcion::where('idalumno', $alumno->id)
        ->where('idevento', $id)
        ->first();

    if (!$inscripcion) {
        return response()->json(['status' => 404, 'message' => 'Inscripción no encontrada.'], 404);
    }

    $evento = Evento::find($id);
    $inscripcion->delete();

    // Email de confirmación de cancelación
    $contacto = new ControladorContacto();
    $contacto->confirmarCancelacion($alumno->nombre, $alumno->apellidos, $alumno->email,        $evento->titulo,$evento->fecha, $evento->hora);

    return response()->json([
        'status' => 200,
        'message' => 'Inscripción cancelada correctamente.'
    ]);
    }
}
