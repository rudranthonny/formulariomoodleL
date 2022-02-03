<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProgramaController;
use App\Http\Controllers\Admin\InicioController;
use App\Http\Controllers\Admin\MatriculaController;
use App\Http\Controllers\Admin\PlantillaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\InscripcionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('categorias', CategoriaController::class)->names('admin.categorias');
Route::get('categorias/{id}/veliminar',[CategoriaController::class,'veliminar'])->name('admin.categorias.veliminar');
Route::post('categorias/{id}/eliminar',[CategoriaController::class,'eliminar'])->name('admin.categorias.eliminar');
//modulo programas
Route::resource('programas', ProgramaController::class)->names('admin.programas');
// modulo plantilla
Route::resource('plantillas', PlantillaController::class)->names('admin.plantillas');
Route::get('plantillas/{id}/asignar',[PlantillaController::class,'asignar'])->name('admin.plantillas.asignar');
Route::post('plantillas/agregarcurso',[PlantillaController::class,'agregarcurso'])->name('admin.plantillas.agregarcurso');
Route::post('plantillas/eliminarcurso',[PlantillaController::class,'eliminarcurso'])->name('admin.plantillas.eliminarcurso');
//modulo inicio
Route::resource('inicios', InicioController::class)->names('admin.inicios');
Route::get('inicios/{id}/activar', [InicioController::class,'activar'])->name('admin.inicios.activar');
//modulo usuarios
Route::resource('usuarios', UsuarioController::class)->names('admin.usuarios');
Route::post('usuarios/consulta',[UsuarioController::class,'consulta'])->name('admin.usuarios.consulta');
Route::get('usuarios/{id}/agregarprograma',[UsuarioController::class,'agregarprograma'])->name('admin.usuarios.agregarprograma');
Route::get('usuarios/{username}/consultapdf',[UsuarioController::class,'consultapdf'])->name('admin.usuarios.consultapdf');
//matricula
Route::resource('matriculas', MatriculaController::class)->names('admin.matriculas');
Route::post('matriculas/{id}/agregarprograma',[MatriculaController::class,'agregarmatricula'])->name('admin.matriculas.agregarmatricula');
Route::delete('matriculas/{id}/eliminarprograma',[MatriculaController::class,'eliminarprograma'])->name('admin.matriculas.eliminarprograma');
Route::get('matriculas/{variable}/export',[MatriculaController::class,'matriculasexport'])->name('admin.matriculas.export');

//inscripciones
Route::resource('inscripciones', InscripcionController::class)->names('admin.inscripciones');
Route::get('inscripciones/{eliminar}/eliminarall', [InscripcionController::class,'eliminarall'])->name('admin.inscripciones.eliminarall');
Route::get('inscripciones/{variable}/export',[InscripcionController::class,'inscripcionesexport'])->name('admin.inscripciones.export');
//enviar mensaje
//Route::get('send-email/{estudiante_id}',[MailController::class,'sendEmail'])->name('admin.mensaje.enviar');


