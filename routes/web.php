<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\Recursos;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AlumnoMiddleware;
use App\Http\Middleware\ProfesorMiddleware;
use App\Http\Middleware\UsuarioMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(InicioController::class)->group(function () {
    Route::get('/', 'inicio');
    Route::post('acceso', 'acceso');
    Route::get('salir', 'salir');
    Route::get('edisal/usuario/login', 'salir');
});
Route::middleware(UsuarioMiddleware::class)->group(function () {
    Route::middleware(AlumnoMiddleware::class)->group(function () {
        Route::controller(AlumnoController::class)->prefix('alumno')->group(function () {
            Route::get('inicio/{id}', 'inicio');
            Route::get('extension/consultar/{grado_id}/{materia_id}/{materia}', 'consultarExtencion');
            Route::post('/extension/temas', 'temas');
            Route::get('/extension/mostrarTema', 'mostrarTema');
            Route::get('/extension/archivos', 'mostraArchivos');
            Route::get('recursos/{id}', 'mostrarRecurso');
            Route::get('ver/{id}/{grado}/{materia}/{archivo}', 'verLibreta');
        });
    });
    Route::middleware(ProfesorMiddleware::class)->group(function () {
        Route::controller(ProfesorController::class)->prefix('profesor')->group(function () {
            //---  Recursos ---------------------------------------------------------------------
            Route::get('recursos/{id}', 'mostrarRecurso');
            Route::get('ver/{id}/{grado}/{materia}/{archivo}', 'verLibreta');
            Route::get('extencion/{id}', 'mostrarListaExtenciones');
            Route::get('extension/consultar/{grado_id}/{materia_id}/{materia}', 'consultarExtencion');
            Route::post('/extension/temas', 'temas');
            Route::get('/extension/mostrarTema', 'mostrarTema');
            Route::get('/extension/archivos', 'mostraArchivos');
            Route::get('planificiacion/{id}', 'verPlanificacion');
            Route::get('planificacion/mostrarRecursos/{grado_id}/{materia_id}/{materia}', 'mostrarRecursoPlanificacion');
            Route::post('planificacion/archivos', 'planificacionArchivos');
            Route::get('formacionDocente', 'formacionDocente');
            Route::get('verFormacion/{id}', 'verFormacion');
        });
    });
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::controller(AdminController::class)->prefix('admin')->group(function () {
            //---  Institucion ---------------------------------------------------------------------
            Route::get('institucion', 'listaInstitucion');
            Route::post('nuevaInstitucion', 'nuevaInstitucion');
            Route::post('nuevaImagen', 'nuevaImagen');
            Route::post('buscarInstitucion', 'buscarInstitucion');
            Route::post('editarInstitucion', 'editarInstitucion');
            Route::get('eliminarInstitucion/{id}', 'eliminarInstitucion');
            //---  Usuario ---------------------------------------------------------------------
            Route::get('usuario', 'listaUsuario');
            Route::post('nuevoUsuario', 'nuevoUsuario');
            Route::post('buscarUsuario', 'buscarUsuario');
            Route::post('editarUsuario', 'editarUsuario');
            Route::get('eliminarUsuario/{id}', 'eliminarUsuario');
            //---  Grado ---------------------------------------------------------------------
            Route::get('grado', 'listaGrado');
            Route::post('nuevoGrado', 'nuevoGrado');
            Route::get('eliminarGrado/{id}', 'eliminarGrado');
            Route::get('obtenerGrado/{id}', 'obtenerGrados');
            //---  Seccion ---------------------------------------------------------------------
            Route::get('seccion', 'listaSeccion');
            Route::post('nuevaSeccion', 'nuevaSeccion');
            Route::get('eliminarSeccion/{id}', 'eliminarSeccion');
            Route::get('obtenerSeccion/{id}', 'obtenerSeccion');
            //---  Materia ---------------------------------------------------------------------
            Route::get('materia', 'listaMateria');
            Route::post('nuevaMateria', 'nuevaMateria');
            Route::get('eliminarMateria/{id}', 'eliminarMateria');
            Route::get('cargarMateria/{id}', 'cargarMateria');
            //---  Profesor ---------------------------------------------------------------------
            Route::get('profesor', 'listaProfesor');
            //_______Profesor encargado
            Route::get('nuevoEn', 'nuevoEn');
            Route::post('crearEncargado', 'crearEncargado');
            Route::get('obtenerProfesor/{id}', 'obtenerProfesor');
            Route::get('eliminarEncargado/{id}', 'eliminarEncargado');
            //_______Profesor especial
            Route::get('nuevoEs', 'nuevoEs');
            Route::post('crearEspecial', 'crearEspecial');
            Route::get('eliminarEspecial/{id}', 'eliminarEspecial');
            //---  Alumno ---------------------------------------------------------------------
            Route::get('alumno', 'listaAlumno');
            Route::get('obtenerAlumno/{id}', 'obtenerAlumno');
            Route::post('nuevoAlumno', 'nuevoAlumno');
            Route::get('eliminarAlumno/{id}', 'eliminarAlumno');

            Route::get('alumnos', 'subirAlumnos');
            Route::post('guardarAlumunos', 'postRegistrarAlumnos');
        });
        Route::controller(RecursoController::class)->prefix('edisal')->group(function () {
            //Recursos
            Route::get('recursos', 'listarRecursos');
            Route::get('recursos/web/{id}/{grado}/{materia}/{archivo}', 'verRecurso');
            Route::get('nuevoRecurso', 'nuevoRecurso');
            Route::post('guardarRecurso', 'guardarRecurso');
            Route::get('eliminarResurso/{id}', 'eliminarResurso');
            //Extenciones
            Route::get('extencion', 'listaExtenciones');
            Route::get('extension/mostrar/{id}', 'extensionMostrar');
            Route::get('nuevaExtencion', 'nuevaExtencion');
            Route::post('guardarExtencion', 'guardarExtencion');
            //planificaciones
            Route::get('planificacion', 'listaPlanificaciones');
            Route::get('planificacionMostrar/{id}', 'planificacionMostrar');
            //formacion Docente
            Route::get('formacionDocente', 'formacionDocente');
            Route::get('nuevaFor', 'nuevaFormacionDocente');
            Route::post('crearFormacion', 'crearFormacion');
            Route::get('verFormacion/{id}', 'verFormacion');
            Route::get('editarFormacion/{id}', 'editarFormacion');
            Route::get('eliminarFormacion/{id}', 'eliminarFormacion');
            Route::get('descargaArchivoFormacion/{id}/{archivo}', 'descargaArchivoFormacion');
            Route::post('actualizarFormacion', 'actualizarFormacion');
        });
    });
});
