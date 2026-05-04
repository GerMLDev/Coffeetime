<?php

use App\Http\Controllers\ControladorAlumno;
use App\Http\Controllers\ControladorIndex;
use App\Http\Controllers\ControladorProfesor;
use App\Http\Controllers\ControladorUsuario;
use App\Http\Controllers\ControladorEvento;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorIndex::class, 'Home'])->name('home');
Route::get('/recursos', [ControladorIndex::class, 'Recursos'])->name('recursos');
Route::get('/informate', [ControladorIndex::class, 'Informate'])->name('informate');
Route::get('/eventos', [ControladorEvento::class, 'mostrarData'])->name('eventos');
Route::get('/eventos/recargar', [ControladorEvento::class, 'recargar'])->name('evento.recargar');
Route::get('/login', [ControladorIndex::class, 'VistaLogin'])->name('login');
Route::post('/login', [ControladorIndex::class, 'Autenticarse']);
Route::get('/login/api', [ControladorUsuario::class, 'MostrarApi'])->name('api');

//Registro Usuario del Login
Route::get('/login/loginagregarusuario', [ControladorIndex::class, 'LoginAñadirUsuario'])->name('loginusuario');
Route::post('/login/loginagregarusuario/registrousuario', [ControladorUsuario::class, 'RegistroUsuarioLogin'])->name('registrousuariologin');

Route::post('/logout', [ControladorIndex::class, 'CerrarSesion'])->name('logout');

// Rutas autenticadas para inscripción de alumnos
Route::middleware(['auth'])->group(function () {
    Route::post('/eventos/{id}/inscribir', [ControladorEvento::class, 'inscribir'])->name('evento.inscribir');
    Route::delete('/eventos/{id}/cancelar-inscripcion', [ControladorEvento::class, 'cancelarInscripcion'])->name('evento.cancelar-inscripcion');
});

//MIDDLEWARE ADMINISTRADOR
Route::middleware(['auth', 'role:admin'])->group(function () {

    //REGISTROS

    //Usuario
    Route::get('/agregarusuario', [ControladorIndex::class, 'AñadirUsuario'])->name('agregarusuario');
    Route::post('agregarusuario/registrousuario', [ControladorUsuario::class, 'RegistroUsuario'])->name('registrousuario');


    //Profesor
    Route::get('/agregarprofesor', [ControladorIndex::class, 'AñadirProfesor'])->name('agregarprofe');
    Route::post('agregarprofesor/registroprofe', [ControladorProfesor::class, 'RegistroProfesor'])->name('registroprofe');




    //GESTIONAR REGISTROS (CRUD)
    //Usuario
    Route::get('/gestionarusuario', [ControladorUsuario::class, 'mostrarData'])->name('gestionarusuario');
    Route::get('/gestionarusuario/recargar', [ControladorUsuario::class, 'recargar'])->name('usuario.recargar');


    Route::get('/gestionarusuario/editar/{id}', [ControladorUsuario::class, 'editar'])->where(array('id' => '[0-9]+'))->name('usuario.editar');
    Route::post('/gestionarusuario/editar/{id}', [ControladorUsuario::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('usuario.actualizar');

    Route::delete('/gestionarusuario/eliminar/{id}', [ControladorUsuario::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('usuario.eliminar');
});
/////////////////////////////////////////////////////////////////////////////////

//MIDDLEWARE COMPARTIDO (ADMINISTRADOR Y PROFESOR)

Route::middleware(['auth', 'role:admin,profesor'])->group(function () {
    //INICIO
    Route::get('/gestor', [ControladorIndex::class, 'VistaGestor'])->name('gestor');
    Route::get('/dashboard', [ControladorAlumno::class, 'dashboardNivel'])->name('dashboardNivel');
    Route::get('/dashboardProfesor', [ControladorAlumno::class, 'dashboardProfesor'])->name('dashboardProfesor');

    //REGISTROS

    //Alumno
    Route::get('/loginagregaralumno', [ControladorIndex::class, 'LoginAñadirAlumno'])->name('loginalumno');
    Route::post('/login/loginagregaralumno/registroalumnologin', [ControladorAlumno::class, 'RegistroAlumnoLogin'])->name('registroalumnologin');
    Route::get('/agregaralumno', [ControladorIndex::class, 'AñadirAlumno'])->name('agregaralumno');
    Route::post('agregaralumno/registroalumno', [ControladorAlumno::class, 'RegistroAlumno'])->name('registroalumno');

    // EVENTOS
    Route::post('/eventos/registrar', [ControladorEvento::class, 'registrar'])->name('evento.registrar');
    Route::delete('/eventos/eliminar/{id}', [ControladorEvento::class, 'eliminarData'])->where(['id' => '[0-9]*'])->name('evento.eliminar');

    //GESTIONAR REGISTROS (CRUD)

    //Profesor
    Route::get('/gestionarprofesor', [ControladorProfesor::class, 'mostrarData'])->name('gestionarprofe');
    Route::get('/gestionarprofesor/recargar', [ControladorProfesor::class, 'recargar'])->name('profesor.recargar');


    Route::post('/gestionarprofesor/editar/{id}', [ControladorProfesor::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('profesor.editar');


    Route::delete('/gestionarprofesor/eliminar/{id}', [ControladorProfesor::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('profesor.eliminar');

    //Alumno
    Route::get('/gestionaralumno', [ControladorAlumno::class, 'mostrarData'])->name('gestionaralumno');
    Route::get('/gestionaralumno/recargar', [ControladorAlumno::class, 'recargar'])->name('alumno.recargar');

    Route::get('/gestionaralumno/editar/{id}', [ControladorAlumno::class, 'editar'])->where(array('id' => '[0-9]*'))->name('alumno.editar');
    Route::post('/gestionaralumno/editar/{id}', [ControladorAlumno::class, 'actualizar'])->where(array('id' => '[0-9]*'))->name('alumno.actualizar');


    Route::delete('/gestionaralumno/eliminar/{id}', [ControladorAlumno::class, 'eliminarData'])->where(array('id' => '[0-9]*'))->name('alumno.eliminar');
});

