<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Nivel;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ControladorAlumno extends Controller
{
    function obtenerAlumnos()
    {
        $alumnos = Alumno::all();

        return view('GestionarAlumno', [
            'alumnos' => $alumnos

        ]);
    }
    public function RegistroAlumnoWeb(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dni' => 'required|string|max:20',
            'usuario' => 'required|string|max:255',
            'contraseña' => 'required|string|min:6',
            'idnivel' => 'required|integer|exists:nivel,id',
        ]);

         //Notificacion de duplicidad

        if (Usuario::where('usuario', $request->usuario)->first()) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está en uso.');
        }

        if (Usuario::where('email', $request->email)->first()) {
            return redirect()->back()->with('error', 'El email ya está registrado.');
        }

        if (Usuario::where('dni', $request->dni)->first()) {
            return redirect()->back()->with('error', 'El DNI ya está registrado.');
        }

        $profesores = Profesor::where('idnivel', $request->idnivel)->get();

        if ($profesores->isEmpty()) {
            return redirect()->back()->with('error', 'No hay profesores disponibles para el nivel seleccionado.');
        }
        //Crea usuario
        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol = 3;
        $usuario->save();


        //Crea ficha de alumno
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->email = $request->email;
        $alumno->dni = $request->dni;
        $alumno->usuario = $request->usuario;
        $alumno->contraseña = $request->contraseña;
        $alumno->idnivel = $request->idnivel;
        $profesor = $profesores->random();
        $alumno->idprofesor = $profesor->id;
        $alumno->idrol = 3;
        $alumno->save();

        return redirect('/')->with('success', 'Alumno registrado correctamente.');
    }
    public function RegistroAlumno(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dni' => 'required|string|max:20',
            'usuario' => 'required|string|max:255',
            'contraseña' => 'required|string|min:6',
            'idnivel' => 'required|integer|exists:nivel,id',
            'idprofesor' => 'required|integer|exists:profesor,id',
        ]);

         //Notificacion de duplicidad

        if (Usuario::where('usuario', $request->usuario)->first()) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está en uso.');
        }

        if (Usuario::where('email', $request->email)->first()) {
            return redirect()->back()->with('error', 'El email ya está registrado.');
        }

        if (Usuario::where('dni', $request->dni)->first()) {
            return redirect()->back()->with('error', 'El DNI ya está registrado.');
        }

        //Crea usuario

        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol = 3;
        $usuario->save();


        //Crea ficha de alumno
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:alumno,email,' . $id,
            'dni' => 'required|string|max:20|unique:alumno,dni,' . $id,
            'usuario' => 'required|string|max:255|unique:alumno,usuario,' . $id,
            'contraseña' => 'nullable|string|min:6',
            'nivel' => 'required|integer|exists:nivel,id',
            'profesor' => 'required|integer|exists:profesor,id',
        ]);

        $alumno = Alumno::findOrFail($id);
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->email = $request->email;
        $alumno->dni = $request->dni;
        $alumno->usuario = $request->usuario;
        if ($request->filled('contraseña')) {
            $alumno->contraseña = Hash::make($request->contraseña);
        }
        $alumno->idnivel = $request->nivel;
        $alumno->idprofesor = $request->profesor;
        $alumno->idrol = 3;

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
        //Recupera el profesor de alumno y el nivel
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

        $misAlumnos = Alumno::where('idprofesor', Auth::user()->id)->get();

        return view('dashboardProfe', [
            'datos' => $datos,
            'misAlumnos' => $misAlumnos
        ]);
    }


    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();
        $usuario = Usuario::find($user->id);

        $validaciones = [
            'contraseña' => 'nullable|string|min:6',
        ];

        if ($user->idrol == 3) {
            $validaciones = array_merge($validaciones, [
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
        } elseif ($user->idrol == 2) {
            $validaciones = array_merge($validaciones, [
                'nombre_profesor' => 'required|string|max:255',
                'apellidos_profesor' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
        }

        $request->validate($validaciones);

        if ($user->idrol == 3) {
            $perfil = Alumno::where('usuario', $user->usuario)->first();
            if ($perfil) {
                $perfil->nombre = $request->nombre;
                $perfil->apellidos = $request->apellidos;
                $perfil->email = $request->email;
                if ($request->filled('contraseña')) {
                    $perfil->contraseña = $request->contraseña;
                }
            }
        } elseif ($user->idrol == 2) {
            $perfil = Profesor::where('usuario_prof', $user->usuario)->first();
            if ($perfil) {
                $perfil->nombre_profesor = $request->nombre_profesor;
                $perfil->apellidos_profesor = $request->apellidos_profesor;
                $perfil->email_profesor = $request->email;
                if ($request->filled('contraseña')) {
                    $perfil->contrasena_prof = $request->contraseña;
                }
            }
        }

        if (! isset($perfil) || ! $perfil) {
            return response()->json([
                'status'  => 404,
                'message' => 'Perfil no encontrado.',
            ], 404);
        }

        $perfil->save();

        if ($usuario) {
            $this->sincronizarUsuarioPerfil($usuario, $request);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Perfil actualizado correctamente',
        ]);
    }

    private function sincronizarUsuarioPerfil(Usuario $usuario, Request $request)
    {
        $usuario->email = $request->email;

        if ($request->filled('contraseña')) {
            $usuario->contraseña = Hash::make($request->contraseña);
        }

        $usuario->save();
    }
}
