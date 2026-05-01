<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class ControladorUsuario extends Controller
{

    public function RegistroUsuarioLogin(Request $request){

        $usuario= new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña= Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol =$request->idrol; 

        //POR DEFECTO sería el IDRol de usuario de ALUMNO (3) para que pueda registrarse pero no pueda acceder a la gestión de usuarios.
     
        $usuario->save();

        return redirect('/login')->with('success', 'Usuario registrado correctamente.');
    }  
    public function RegistroUsuario(Request $request){

        $usuario= new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->contraseña= Hash::make($request->contraseña);
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->idrol =$request->idrol; 

        $usuario->save();

        return redirect('/agregarusuario')->with('success', 'Usuario registrado correctamente.');
    }  

    public function MostrarApi(){

        $usuario = (new Usuario())->all();

        return $usuario; 

    }

          //CRUD


    public function consultar($id){

        $usuario = (new Usuario())->obtenerUsuarioRol($id);

        return view('consultarusuario', compact('usuario')); 

    }

    public function editar($id)
    {
        $usuario = Usuario::where('id',$id)->first();
        $roles= Rol::all();

        return response()->json([
            'status' => 200,
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }

    
    
     public function actualizar(Request $request, $id)
     {
 
         $usuario = Usuario::findOrFail($id); 
         $usuario->usuario = $request->usuario;
         $usuario->contraseña = Hash::make($request->contraseña);
         $usuario->email = $request->email;
         $usuario->dni= $request->dni;
         $usuario->idrol= $request->rol;
        
         $usuario->save();
 
         return response()->json([
            'status' => 200,
            'message' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario,
        ]);    
         }
 

    public function eliminarData($id) {
        $usuario = Usuario::where('id', $id)->first();
        $usuario->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario borrado correctamente'
        ]);
    }

    public function mostrarData() {
        $usuario = Usuario::all();

        return view('gestionarusuario', [
            'usuario' => $usuario         
        ]);
    }
    
    public function consultarData($id){

        $usuario = (new Usuario())->obtenerUsuarioRol($id);

        return view('consultarusuario', compact('usuario')); 

    }

    public function recargar() {
        $usuario = Usuario::with('role')->get(); 
        //Recupera el rol de usuario

        return response()->json([
            'status' => 200,
            'usuario' => $usuario,
        ]);
    }
}
