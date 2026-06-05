<?php

use App\Http\Controllers\ControladorAlumno;
use App\Http\Controllers\ControladorIndex;
use App\Http\Controllers\ControladorProfesor;
use App\Http\Controllers\ControladorUsuario;
use App\Http\Controllers\ControladorEvento;
use App\Http\Controllers\ControladorContacto;
use App\Http\Controllers\ControladorRecurso;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorIndex::class, 'Home'])->name('home');
Route::get('/informate', [ControladorIndex::class, 'Informate'])->name('informate');
Route::post('/informate/enviar', [ControladorContacto::class, 'enviar'])->name('contacto.enviar');
Route::get('/eventos', [ControladorEvento::class, 'mostrarData'])->name('eventos');
Route::get('/recursos', [ControladorRecurso::class, 'mostrarData'])->name('recursos');
Route::get('/recursos/recargar', [ControladorRecurso::class, 'recargar'])->name('recurso.recargar');

Route::middleware(['auth'])->group(function () {

//EVENTOS
    Route::get('/eventos/recargar', [ControladorEvento::class, 'recargar'])->name('evento.recargar');
    Route::post('/eventos/{id}/inscribir', [ControladorEvento::class, 'inscribir'])->name('evento.inscribir');
    Route::delete('/eventos/{id}/cancelar-inscripcion', [ControladorEvento::class, 'cancelarInscripcion'])->name('evento.cancelar-inscripcion');

    //PERFIL DE USUARIO
    Route::get('/perfil', [ControladorIndex::class, 'VistaPerfil'])->name('perfil');
    Route::post('/perfil/actualizar', [ControladorAlumno::class, 'actualizarPerfil'])->name('perfil.actualizar');

});
Route::get('/login', [ControladorIndex::class, 'VistaLogin'])->name('login');
Route::post('/login', [ControladorIndex::class, 'Autenticarse']);



//Registro usuario Alumno nuevo desde WEB
Route::get('/anadiralumno', [ControladorIndex::class, 'WebAnadirAlumno'])->name('anadiralumno');
    Route::post('/anadiralumno/registroalumnoweb', [ControladorAlumno::class, 'RegistroAlumnoWeb'])->name('registroalumnoweb');


//Registro Usuario del Login
Route::get('/login/loginagregarusuario', [ControladorIndex::class, 'LoginAnadirUsuario'])->name('loginusuario');
Route::post('/login/loginagregarusuario/registrousuario', [ControladorUsuario::class, 'RegistroUsuarioLogin'])->name('registrousuariologin');

//Cerrar Sesión
Route::post('/logout', [ControladorIndex::class, 'CerrarSesion'])->name('logout');

//MIDDLEWARE ADMINISTRADOR
Route::middleware(['auth', 'role:admin'])->group(function () {

    //REGISTROS en GESTOR

    //Usuario
    Route::get('/agregarusuario', [ControladorIndex::class, 'AnadirUsuario'])->name('agregarusuario');
    Route::post('agregarusuario/registrousuario', [ControladorUsuario::class, 'RegistroUsuario'])->name('registrousuario');


    //Profesor
    Route::get('/agregarprofesor', [ControladorIndex::class, 'AnadirProfesor'])->name('agregarprofe');
    Route::post('agregarprofesor/registroprofe', [ControladorProfesor::class, 'RegistroProfesor'])->name('registroprofe');

    //GESTIONAR REGISTROS (CRUD)
    //Usuario
    Route::get('/gestionarusuario', [ControladorUsuario::class, 'mostrarData'])->name('gestionarusuario');
    Route::get('/gestionarusuario/recargar', [ControladorUsuario::class, 'recargar'])->name('usuario.recargar');

    Route::get('/gestionarusuario/editar/{id}', [ControladorUsuario::class, 'editar'])->where(array('id' => '[0-9]+'))->name('usuario.editar');
    Route::post('/gestionarusuario/editar/{id}', [ControladorUsuario::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('usuario.actualizar');

    Route::delete('/gestionarusuario/eliminar/{id}', [ControladorUsuario::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('usuario.eliminar');


    //API DE USUARIOS
    Route::get('/gestor/api', [ControladorUsuario::class, 'MostrarApi'])->name('api');
});

//MIDDLEWARE COMPARTIDO (ADMINISTRADOR Y PROFESOR)

Route::middleware(['auth', 'role:admin,profesor'])->group(function () {
    //INICIO
    Route::get('/gestor', [ControladorIndex::class, 'VistaGestor'])->name('gestor');
    Route::get('/dashboard', [ControladorAlumno::class, 'dashboardNivel'])->name('dashboardNivel');
    Route::get('/dashboardProfesor', [ControladorAlumno::class, 'dashboardProfesor'])->name('dashboardProfesor');

    //REGISTROS

    //Alumno

    Route::get('/agregaralumno', [ControladorIndex::class, 'AnadirAlumno'])->name('agregaralumno');
    Route::post('agregaralumno/registroalumno', [ControladorAlumno::class, 'RegistroAlumno'])->name('registroalumno');

    // EVENTOS y RECURSOS
    Route::post('/eventos/registrar', [ControladorEvento::class, 'registrar'])->name('evento.registrar');
    Route::get('/eventos/{id}/inscripciones', [ControladorEvento::class, 'obtenerInscripciones'])->where(['id' => '[0-9]*'])->name('evento.inscripciones');
    Route::delete('/eventos/eliminar/{id}', [ControladorEvento::class, 'eliminarData'])->where(['id' => '[0-9]*'])->name('evento.eliminar');
    Route::post('/recursos/registrar', [ControladorRecurso::class, 'registrar'])->name('recurso.registrar');
    Route::delete('/recursos/eliminar/{id}', [ControladorRecurso::class, 'eliminarData'])->where(['id' => '[0-9]*'])->name('recurso.eliminar');

    //GESTIONAR REGISTROS (CRUD)

    //Profesor
    Route::get('/gestionarprofesor', [ControladorProfesor::class, 'mostrarData'])->name('gestionarprofe');
    Route::get('/gestionarprofesor/recargar', [ControladorProfesor::class, 'recargar'])->name('profesor.recargar');

Route::get('/gestionarprofesor/editar/{id}', [ControladorProfesor::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('profesor.editar');
    Route::post('/gestionarprofesor/editar/{id}', [ControladorProfesor::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('profesor.actualizar');
    Route::delete('/gestionarprofesor/eliminar/{id}', [ControladorProfesor::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('profesor.eliminar');

    //Alumno
    Route::get('/gestionaralumno', [ControladorAlumno::class, 'mostrarData'])->name('gestionaralumno');
    Route::get('/gestionaralumno/recargar', [ControladorAlumno::class, 'recargar'])->name('alumno.recargar');

    Route::get('/gestionaralumno/editar/{id}', [ControladorAlumno::class, 'editar'])->where(array('id' => '[0-9]*'))->name('alumno.editar');
    Route::post('/gestionaralumno/editar/{id}', [ControladorAlumno::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('alumno.actualizar');


    Route::delete('/gestionaralumno/eliminar/{id}', [ControladorAlumno::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('alumno.eliminar');
});

