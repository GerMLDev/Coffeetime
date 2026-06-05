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
    public function RegistroProfesor(Request $request)
    {
        $request->validate([
            'nombre_profesor' => 'required|string|max:255',
            'apellidos_profesor' => 'required|string|max:255',
            'email_profesor' => 'required|email|max:255',
            'dni_profesor' => 'required|string|max:20',
            'usuario_prof' => 'required|string|max:255',
            'contrasena_prof' => 'required|string|min:6',
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

        // Usamos una transacción para asegurarnos de que se guarden ambos o ninguno
        DB::transaction(function () use ($request) {
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

    public function consultar($id)
    {
        $profesor = (new Profesor())->obtenerProfesor($id);
        $alumnonivel = (new Alumno())->obtenerProfesordeAlumno($id);

        return view('consultarprofesor', compact('profesor', 'alumnonivel'));
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
        $request->validate([
            'nombre_profesor' => 'required|string|max:255',
            'apellidos_profesor' => 'required|string|max:255',
            'email_profesor' => 'required|email|max:255|unique:profesor,email_profesor,' . $id,
            'dni_profesor' => 'required|string|max:20|unique:profesor,dni_profesor,' . $id,
            'usuario_prof' => 'required|string|max:255|unique:profesor,usuario_prof,' . $id,
            'contrasena_prof' => 'nullable|string|min:6',
            'idnivel' => 'required|integer|exists:nivel,id',
        ]);

        $profesor = Profesor::findOrFail($id);
        $profesor->nombre_profesor = $request->nombre_profesor;
        $profesor->apellidos_profesor = $request->apellidos_profesor;
        $profesor->email_profesor = $request->email_profesor;
        $profesor->dni_profesor = $request->dni_profesor;
        $profesor->usuario_prof = $request->usuario_prof;
        if ($request->filled('contrasena_prof')) {
            $profesor->contrasena_prof = Hash::make($request->contrasena_prof);
        }
        $profesor->idnivel = $request->idnivel;
        $profesor->idrol = 2;

        $this->sincronizarUsuarioProfesor($profesor, $request);

        $profesor->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profesor actualizado correctamente.',
            'profesor' => $profesor,
        ]);
    }

    private function sincronizarUsuarioProfesor(Profesor $profesor, Request $request)
    {
        if ($profesor->idusuario) {
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

            // Guardamos el ID del usuario vinculado antes de borrar el profesor
            $idUsuario = $profesor->idusuario;

            DB::transaction(function () use ($profesor, $idUsuario) {
                // 1. Borramos el registro del profesor
                $profesor->delete();

                // 2. Borramos la cuenta de usuario global si existe vinculada
                if ($idUsuario) {
                    Usuario::where('id', $idUsuario)->delete();
                }
            });

            return response()->json([
                'status' => 200,
                'mensaje' => 'Profesor y su cuenta de usuario borrados correctamente.'
            ]);

        } catch (\Exception $e) {
            // Si hay restricciones de clave foránea (ej. el profesor subió recursos o tiene eventos), saltará aquí
            return response()->json([
                'status' => 500,
                'mensaje' => 'No se pudo eliminar al profesor. Asegúrate de que no tenga recursos vinculados o eventos asignados.'
            ], 500);
        }
    }

    public function mostrarData()
    {
        $profesor = Profesor::all();
        $niveles = Nivel::all();
        return view('gestionarprofesor', [
            'profesor' => $profesor,
            'niveles' => $niveles
        ]);
    }

    public function consultarData($id)
    {
        $profesor = (new Profesor())->obtenerProfesor($id);
        return view('consultarprofesor', compact('profesor'));
    }

    public function recargar()
    {
        $profesor = Profesor::with('nivel')->get()->values();

        return response()->json([
            'status' => 200,
            'profesor' => $profesor,
        ]);
    }
}
