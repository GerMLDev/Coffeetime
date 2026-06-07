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
    // Carga todos los alumnos para el panel de gestión
    function obtenerAlumnos()
    {
        $alumnos = Alumno::all();

        return view('GestionarAlumno', [
            'alumnos' => $alumnos

        ]);
    }
    // Registra un alumno desde el formulario web público
    public function RegistroAlumnoWeb(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dni' => 'required|string|regex:/^\d{8}[A-Z]$/|unique:alumno,dni',
            'usuario' => 'required|string|max:255|unique:alumno,usuario',
            'contraseña' => 'required|string|min:8',
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
        // Crea el usuario del alumno
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
    // Registra un alumno desde el panel de administración
    public function RegistroAlumno(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dni' => 'required|string|regex:/^\d{8}[A-Z]$/|unique:alumno,dni',
            'usuario' => 'required|string|max:255|unique:alumno,usuario',
            'contraseña' => 'required|string|min:8',
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

        // Crea el usuario del alumno

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

    // Muestra los datos de un alumno en la vista de consulta
    public function consultar($id)
    {
        $alumno = (new Alumno())->obtenerAlumno($id);
        return view('consultaralumno', compact('alumno'));
    }

    // Carga datos del alumno para editarlos por AJAX

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

    // Actualiza los datos de un alumno

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:alumno,email,' . $id,
            'dni' => 'required|string|max:9|regex:/^\d{8}[A-Z]$/|unique:alumno,dni,' . $id,
            'usuario' => 'required|string|max:255|unique:alumno,usuario,' . $id,
            'contraseña' => 'nullable|string|min:8',
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

    // Muestra todos los alumnos en la gestión
    public function mostrarData()
    {
        $alumno = Alumno::all();

        return view('gestionaralumno', [
            'alumno' => $alumno
        ]);
    }

    // Elimina un alumno por id
    public function eliminarData($id)
    {

        $alumno = Alumno::where('id', $id)->first();

        $alumno->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Alumno borrado correctamente'
        ]);
    }
    // Recarga alumnos con su profe y nivel para la tabla
    public function recargar()
    {
        //Recupera el profesor de alumno y el nivel
        $alumno = Alumno::with(['profe', 'nivel'])->get();
        return response()->json([
            'status' => 200,
            'alumno' => $alumno,
        ]);
    }


    // Muestra dashboard de alumnos por nivel
    public function dashboardNivel()
    {
        $datos = (new Alumno())->getAlumnosPorNivel();

        return view('dashboard', [
            'datos' => $datos
        ]);
    }

    // Muestra dashboard de alumnos por profesor
    public function dashboardProfesor()
    {

        $datos = (new Alumno())->getAlumnosPorProfesor();

        // Solo carga los alumnos del profe logueado
        $misAlumnos = Alumno::where('idprofesor', Auth::user()->id)->get();

        return view('dashboardProfe', [
            'datos' => $datos,
            'misAlumnos' => $misAlumnos
        ]);
    }


    // Actualiza el perfil del usuario logueado (alumno o profe)
    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();
        $usuario = Usuario::find($user->id);

        $validaciones = [
            'contraseña' => 'nullable|string|min:8',
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
            // Actualiza datos del perfil de alumno
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
            // Actualiza datos del perfil de profesor
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

    // Sincroniza la cuenta de usuario con los cambios del perfil
    private function sincronizarUsuarioPerfil(Usuario $usuario, Request $request)
    {
        $usuario->email = $request->email;

        if ($request->filled('contraseña')) {
            $usuario->contraseña = Hash::make($request->contraseña);
        }

        $usuario->save();
    }
}
