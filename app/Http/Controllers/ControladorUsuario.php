<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class ControladorUsuario extends Controller
{

    public function RegistroUsuarioLogin(Request $request)
    {

    //Validación en servidor
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'contraseña' => 'required|string|min:6',
            'email' => 'required|email|max:255|unique:usuario,email',
            'dni' => 'required|string|max:20|unique:usuario,dni',
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


    public function RegistroUsuario(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'contraseña' => 'required|string|min:6',
            'email' => 'required|email|max:255|unique:usuario,email',
            'dni' => 'required|string|max:20|unique:usuario,dni',
            'idrol' => 'required|integer|exists:rol,id',
        ]);
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

    public function MostrarApi()
    {

        $usuario = (new Usuario())->all();

        return $usuario;
    }

    //CRUD


    public function consultar($id)
    {

        $usuario = (new Usuario())->obtenerUsuarioRol($id);

        return view('consultarusuario', compact('usuario'));
    }

    public function editar($id)
    {
        $usuario = Usuario::where('id', $id)->first();
        $roles = Rol::all();

        return response()->json([
            'status' => 200,
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }



    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuario,usuario,' . $id,
            'contraseña' => 'nullable|string|min:6',
            'email' => 'required|email|max:255|unique:usuario,email,' . $id,
            'dni' => 'required|string|max:20|unique:usuario,dni,' . $id,
            'rol' => 'required|integer|exists:rol,id',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->usuario = $request->usuario;
        if ($request->filled('contraseña')) {
            $usuario->contraseña = Hash::make($request->contraseña);
        }
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol = $request->rol;

        $usuario->save();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario,
        ]);
    }


    public function eliminarData($id)
    {
        $usuario = Usuario::where('id', $id)->first();
        $usuario->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario borrado correctamente'
        ]);
    }

    public function mostrarData()
    {
        $usuario = Usuario::all();

        return view('gestionarusuario', [
            'usuario' => $usuario
        ]);
    }

    public function consultarData($id)
    {

        $usuario = (new Usuario())->obtenerUsuarioRol($id);

        return view('consultarusuario', compact('usuario'));
    }

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
