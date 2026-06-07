<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ControladorUsuario extends Controller
{

    // Registra un usuario desde el login público
    public function RegistroUsuarioLogin(Request $request)
    {

    //Validación en servidor
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'contraseña' => 'required|string|min:8',
            'email' => 'required|email|max:255|unique:usuario,email',
            'dni' => 'required|string|max:9|unique:usuario,dni',
            'idrol' => 'required|integer|exists:rol,id',
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
        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol = $request->idrol;

        //POR DEFECTO sería el IDRol de usuario de ALUMNO (3) para que pueda registrarse pero no pueda acceder a la gestión de usuarios.

        if ($usuario->save()) {
            return redirect('/login')->with('success', 'Usuario registrado correctamente.');
        } else {
            return redirect('/login')->with('error', 'Error al registrar el usuario, posiblemente el nombre de usuario o email ya están en uso.');
        }
    }


    // Registra un usuario desde el panel de administración
    public function RegistroUsuario(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'contraseña' => 'required|string|min:8',
            'email' => 'required|email|max:255|unique:usuario,email',
            'dni' => 'required|string|max:9|unique:usuario,dni',
            'idrol' => 'required|integer|exists:rol,id',
        ]);

        //Control de errores de duplicidad

        if (Usuario::where('usuario', $request->usuario)->first()) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está en uso.');
        }


        if (Usuario::where('email', $request->email)->first()) {
            return redirect()->back()->with('error', 'El email ya está registrado.');
        }
        if (Usuario::where('dni', $request->dni)->first()) {
            return redirect()->back()->with('error', 'El DNI ya está registrado.');
        }

        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol = $request->idrol;

        $usuario->save();

        return redirect('/agregarusuario')->with('success', 'Usuario registrado correctamente.');
    }

    // Devuelve todos los usuarios en formato JSON para la API
    public function MostrarApi(){
        $usuario = (new Usuario())->all();
        return $usuario;
    }

    //CRUD

    // Muestra un usuario con su rol en la vista de consulta
    public function consultar($id){

        $usuario = (new Usuario())->obtenerUsuarioRol($id);
        return view('consultarusuario', compact('usuario'));
    }

    // Carga los datos del usuario para editar desde AJAX
    public function editar($id){
        $usuario = Usuario::where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'usuario' => $usuario,
        ]);
    }



    // Actualiza los datos de un usuario existente
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario,' . $id,
            'contraseña' => 'nullable|string|min:8',
            'email' => 'required|email|max:255|unique:usuario,email,' . $id,
            'dni' => 'required|string|max:9|unique:usuario,dni,' . $id,
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->usuario = $request->usuario;
        if ($request->filled('contraseña')) {
            $usuario->contraseña = Hash::make($request->contraseña);
        }
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;

        $usuario->save();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario,
        ]);
    }


    // Borra un usuario y devuelve resultado JSON
    public function eliminarData($id)
    {
        $usuario = Usuario::where('id', $id)->first();
        $usuario->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario borrado correctamente'
        ]);
    }

    // Muestra todos los usuarios en la página de gestión
    public function mostrarData()
    {
        $usuario = Usuario::all();

        return view('gestionarusuario', [
            'usuario' => $usuario
        ]);
    }

    //Consulta de usuario con rol para la vista pública de consulta
    public function consultarData($id)
    {

        $usuario = (new Usuario())->obtenerUsuarioRol($id);

        return view('consultarusuario', compact('usuario'));
    }

    // Recarga usuarios con relación al rol para la tabla
    public function recargar()
    {
        $usuario = Usuario::with('role')->get();
        //Recupera el rol de usuario

        return response()->json([
            'status' => 200,
            'usuario' => $usuario,
        ]);
    }
}
