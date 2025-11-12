<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\CargaHorariaController;
use App\Http\Controllers\GrupoHorarioController;
use App\Http\Controllers\AsistenciaDocenteController;
use Illuminate\Support\Facades\Route;


Route::post('asistencia-docente/{grupoHorario}', [AsistenciaDocenteController::class, 'marcarAsistencia']);
Route::get('docentes/asistencias', [DocenteController::class, 'obtenerAsistencias']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('usuarios/me', [AuthController::class, 'me']);

Route::get('usuarios/docentes', [UserController::class, 'getDocentes']);

Route::post('usuarios/crearcuentas', [UserController::class, 'crearCuentas']);
Route::get('usuarios', [UserController::class, 'index']);
Route::get('usuarios/{id}', [UserController::class, 'show']);
Route::get('usuarios/{id}/perfil', [UserController::class, 'verPerfil']);
Route::post('usuarios', [UserController::class, 'store']);
Route::put('usuarios/{id}', [UserController::class, 'update']);
Route::patch('usuarios/{id}', [UserController::class, 'update']);
Route::delete('usuarios/{id}', [UserController::class, 'destroy']);


Route::get('docentes/horarios', [DocenteController::class, 'horarios']);

Route::get('docentes', [DocenteController::class, 'index']);
Route::get('docentes/{id}', [DocenteController::class, 'show']);
Route::post('docentes', [DocenteController::class, 'store']);
Route::put('docentes/{id}', [DocenteController::class, 'update']);
Route::patch('docentes/{id}', [DocenteController::class, 'update']);
Route::delete('docentes/{id}', [DocenteController::class, 'destroy']);
Route::post('/docentes/{docenteId}/crear-horarios', [DocenteController::class, 'crearHorariosParaDocente']);

Route::get('grupos', [GrupoController::class, 'index']);
Route::get('grupos/{id}', [GrupoController::class, 'show']);
Route::post('grupos', [GrupoController::class, 'store']);
Route::put('grupos/{id}', [GrupoController::class, 'update']);
Route::patch('grupos/{id}', [GrupoController::class, 'update']);
Route::delete('grupos/{id}', [GrupoController::class, 'destroy']);



Route::get('roles', [RolController::class, 'index']); // Listar roles
Route::get('roles/{id}', [RolController::class, 'show']); // Mostrar un rol específico
Route::post('roles', [RolController::class, 'store']); // Crear un nuevo rol
Route::put('roles/{id}', [RolController::class, 'update']); // Actualizar un rol
Route::patch('roles/{id}', [RolController::class, 'update']); // Usar PATCH para actualización parcial
Route::delete('roles/{id}', [RolController::class, 'destroy']); // Eliminar un rol

Route::get('aulas', [AulaController::class, 'index']); // Listar aulas
Route::get('aulas/{id}', [AulaController::class, 'show']); // Mostrar un rol específico
Route::post('aulas', [AulaController::class, 'store']); // Crear un nuevo rol
Route::put('aulas/{id}', [AulaController::class, 'update']); // Actualizar un rol
Route::patch('aulas/{id}', [AulaController::class, 'update']); // Usar PATCH para actualización parcial
Route::delete('aulas/{id}', [AulaController::class, 'destroy']); // Eliminar un rol


//put complemtamente
//patch parcial
Route::get('materias', [MateriaController::class, 'index']); // Listar aulas
Route::get('materias/{id}', [MateriaController::class, 'show']); // Mostrar un rol específico
Route::post('materias', [MateriaController::class, 'store']); // Crear un nuevo rol
Route::put('materias/{id}', [MateriaController::class, 'update']); // Actualizar un rol
Route::patch('materias/{id}', [MateriaController::class, 'update']); // Actualizar un rol
Route::delete('materias/{id}', [MateriaController::class, 'destroy']); // Eliminar un rol

//
//Route::get('usuarios', [UserController::class, 'index']); // Listar usuarios
//Route::get('usuarios/{idc}', [UserController::class, 'show']); // Mostrar un usuario específico
//Route::post('usuarios', [UserController::class, 'store']); // Crear un nuevo usuario
//Route::put('usuarios/{id}', [UserController::class, 'update']); // Actualizar un usuario
//Route::delete('usuarios/{id}', [UserController::class, 'destroy']); // Eliminar un usuario

// Ruta específica PRIMERO
Route::get('carga_horarias', [CargaHorariaController::class, 'index']);
Route::get('carga_horarias/{id}', [CargaHorariaController::class, 'show']);
Route::post('carga_horarias', [CargaHorariaController::class, 'store']);
Route::put('carga_horarias/{id}', [CargaHorariaController::class, 'update']);
Route::patch('carga_horarias/{id}', [CargaHorariaController::class, 'update']);
Route::delete('carga_horarias/{id}', [CargaHorariaController::class, 'destroy']);


Route::get('gestiones', [GestionController::class, 'index']);  // Mostrar todas las gestiones
Route::get('gestiones/{id}', [GestionController::class, 'show']);  // Mostrar una gestión específica
Route::post('gestiones', [GestionController::class, 'store']);  // Crear una nueva gestión
Route::put('gestiones/{id}', [GestionController::class, 'update']);  // Actualizar una gestión
Route::delete('gestiones/{id}', [GestionController::class, 'destroy']);


Route::get('grupo_horarios/{grupo_id}/gruposDias', [GrupoHorarioController::class, 'gruposDias']); // Ver todos los horarios de un grupo
Route::get('grupo_horarios/{grupo_id}', [GrupoHorarioController::class, 'index']); // Ver todos los horarios de un grupo
Route::post('grupo_horarios', [GrupoHorarioController::class, 'store']); // Crear nuevo horario
Route::get('grupo_horarios/{id}', [GrupoHorarioController::class, 'show']); // Ver un horario específico
Route::put('grupo_horarios/{id}', [GrupoHorarioController::class, 'update']); // Actualizar horario
Route::delete('grupo_horarios/{id}', [GrupoHorarioController::class, 'destroy']); // Eliminar horario


// Ruta específica PRIMERO

Route::get('carga_horarias', [CargaHorariaController::class, 'index']);
Route::get('carga_horarias/{id}', [CargaHorariaController::class, 'show']);
Route::post('carga_horarias', [CargaHorariaController::class, 'store']);
Route::put('carga_horarias/{id}', [CargaHorariaController::class, 'update']);
Route::patch('carga_horarias/{id}', [CargaHorariaController::class, 'update']);
Route::delete('carga_horarias/{id}', [CargaHorariaController::class, 'destroy']);


// Ruta para generar el PDF de la asistencia de los docentes
Route::post('asistencia-docentes/pdf', [AsistenciaDocenteController::class, 'generateAsistenciaDocentesPdf']);

// Ruta para generar el reporte de asistencia de los docentes en formato Excel
Route::post('asistencia-docentes/report', [AsistenciaDocenteController::class, 'generateAsistenciaDocentesReport']);
