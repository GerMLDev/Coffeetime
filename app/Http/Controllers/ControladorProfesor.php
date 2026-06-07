<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Alumno;
use App\Models\Nivel;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ControladorProfesor extends Controller
{
    // Registra un nuevo profesor junto a su usuario
    public function RegistroProfesor(Request $request)
    {
        $request->validate([
            'nombre_profesor' => 'required|string|max:255',
            'apellidos_profesor' => 'required|string|max:255',
            'email_profesor' => 'required|email|max:255|unique:profesor,email_profesor',
            'dni_profesor' => 'required|string|max:20|unique:profesor,dni_profesor',
            'usuario_prof' => 'required|string|max:255|unique:profesor,usuario_prof',
            'contrasena_prof' => 'required|string|min:8',
            'idnivel' => 'required|integer|exists:nivel,id',
        ]);

        // Notificacion de duplicidad
        if (Usuario::where('usuario', $request->usuario_prof)->first()) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está en uso.');
        }

        if (Usuario::where('email', $request->email_profesor)->first()) {
            return redirect()->back()->with('error', 'El email ya está registrado.');
        }

        if (Usuario::where('dni', $request->dni_profesor)->first()) {
            return redirect()->back()->with('error', 'El DNI ya está registrado.');
        }

        DB::transaction(function () use ($request) {
            // Crea usuario y profesor en la misma transacción, si falla uno, no se crea el otro
            $usuario = new Usuario();
            $usuario->usuario = $request->usuario_prof;
            $usuario->contraseña = Hash::make($request->contrasena_prof);
            $usuario->email = $request->email_profesor;
            $usuario->dni = $request->dni_profesor;
            $usuario->idrol = 2;
            $usuario->save();

            $profesor = new Profesor();
            $profesor->nombre_profesor = $request->nombre_profesor;
            $profesor->apellidos_profesor = $request->apellidos_profesor;
            $profesor->email_profesor = $request->email_profesor;
            $profesor->dni_profesor = $request->dni_profesor;
            $profesor->usuario_prof = $request->usuario_prof;
            $profesor->contrasena_prof = Hash::make($request->contrasena_prof);
            $profesor->idnivel = $request->idnivel;
            $profesor->idrol = 2;
            $profesor->idusuario = $usuario->id;
            $profesor->save();
        });

        return redirect('agregarprofesor')->with('success', 'Profesor registrado correctamente.');
    }

    // CRUD

    // Muestra los datos del profe y sus alumnos asociados
    public function consultar($id)
    {
        $profesor = (new Profesor())->obtenerProfesor($id);
        $alumnonivel = (new Alumno())->obtenerProfesordeAlumno($id);

        return view('consultarprofesor', compact('profesor', 'alumnonivel'));
    }

    // Carga un profesor para el formulario de edición
    public function editar($id)
    {
        $profesor = Profesor::find($id);

        return response()->json([
            'status' => 200,
            'profesor' => $profesor,
        ]);
    }

    // Actualiza los datos de un profesor, y sincroniza su usuario asociado
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre_profesor' => 'required|string|max:255',
            'apellidos_profesor' => 'required|string|max:255',
            'email_profesor' => 'required|email|max:255|unique:profesor,email_profesor,' . $id,
            'dni_profesor' => 'required|string|max:20|unique:profesor,dni_profesor,' . $id,
            'usuario_prof' => 'required|string|max:255|unique:profesor,usuario_prof,' . $id,
            'contrasena_prof' => 'nullable|string|min:8',
            'nivel' => 'required|integer|exists:nivel,id',
        ]);

        $profesor = Profesor::findOrFail($id);

        //Control de duplicidad en Usuario, por si a la hora de editar un profesor, hacemos coincidir registros
        $usuarioDuplicado = Usuario::where('id', '!=', $profesor->idusuario)
            ->where(function ($query) use ($request) {
                $query->where('usuario', $request->usuario_prof)
                    ->orWhere('email', $request->email_profesor)
                    ->orWhere('dni', $request->dni_profesor);
            })
            ->first();

        if ($usuarioDuplicado) {
            return response()->json([
                'status' => 422,
                'message' => 'El nombre de usuario, email o DNI ya está en uso por otra cuenta.'
            ], 422);
        }

        //se pasan los datos y se actualiza la información en ambos

        $profesor->nombre_profesor = $request->nombre_profesor;
        $profesor->apellidos_profesor = $request->apellidos_profesor;
        $profesor->email_profesor = $request->email_profesor;
        $profesor->dni_profesor = $request->dni_profesor;
        $profesor->usuario_prof = $request->usuario_prof;
        if ($request->filled('contrasena_prof')) {
            $profesor->contrasena_prof = Hash::make($request->contrasena_prof);
        }
        $profesor->idnivel = $request->nivel;
        $profesor->idrol = 2;

        $this->sincronizarUsuarioProfesor($profesor, $request);

        $profesor->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profesor actualizado correctamente.',
            'profesor' => $profesor,
        ]);
    }

    // Sincroniza los datos del usuario cuando se actualiza un profesor
    private function sincronizarUsuarioProfesor(Profesor $profesor, Request $request)
    {
        if ($profesor->idusuario) {
            // Si ya hay usuario vinculado, lo actualizamos
            $usuario = Usuario::find($profesor->idusuario);
        } else {
            $usuario = new Usuario();
            $usuario->idrol = 2;
        }

        if ($usuario) {
            $usuario->usuario = $request->usuario_prof;
            if ($request->filled('contrasena_prof')) {
                $usuario->contraseña = Hash::make($request->contrasena_prof);
            }
            $usuario->email = $request->email_profesor;
            $usuario->dni = $request->dni_profesor;
            $usuario->save();
            $profesor->idusuario = $usuario->id;
        }
    }

    // Elimina un profesor y su cuenta de usuario asociada
    public function eliminarData($id)
    {
        try {
            $profesor = Profesor::find($id);

            if (!$profesor) {
                return response()->json([
                    'status' => 404,
                    'mensaje' => 'El profesor no existe o ya ha sido eliminado.'
                ], 404);
            }

            $idUsuario = $profesor->idusuario;

            //Borramos todo registro del profesor en una transacción, si falla el borrado de uno, no se borra el otro

            DB::transaction(function () use ($profesor, $idUsuario) {
                $profesor->delete();
                if ($idUsuario) {
                    Usuario::where('id', $idUsuario)->delete();
                }
            });

            return response()->json([
                'status' => 200,
                'mensaje' => 'Profesor y su cuenta de usuario borrados correctamente.'
            ]);


            //Control de error 'deleteoncascade'

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'mensaje' => 'No se pudo eliminar al profesor. Asegúrate de que no tenga recursos vinculados o eventos asignados.'
            ], 500);
        }
    }

    // Muestra la lista de profesores y niveles en el panel interno
    public function mostrarData()
    {
        $profesor = Profesor::all();
        $niveles = Nivel::all();
        return view('gestionarprofesor', [
            'profesor' => $profesor,
            'niveles' => $niveles
        ]);
    }

    // Consulta los datos de un profesor
    public function consultarData($id)
    {
        $profesor = (new Profesor())->obtenerProfesor($id);
        return view('consultarprofesor', compact('profesor'));
    }

    // Recarga la lista de profesores con su nivel
    public function recargar()
    {
        $profesor = Profesor::with('nivel')->get()->values();

        return response()->json([
            'status' => 200,
            'profesor' => $profesor,
        ]);
    }
}
