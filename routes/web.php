<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::get('/departamento/recuperar', [DepartamentoController::class, 'recuperar'])->name('departamento.recuperar');
Route::post('departamento/recuperarsegundo', [DepartamentoController::class, 'recuperarSegundo'])->name('departamento.recuperar.segundo');
Route::get('/departamento/recuperartodos', [DepartamentoController::class, 'recuperarTodos'])->name('departamento.recuperar.todos');
Route::resource('departamento', DepartamentoController::class);

Route::get('puesto/recuperar', [PuestoController::class, 'recuperar'])->name('puesto.recuperar');
Route::post('puesto/recuperarsegundo', [PuestoController::class, 'recuperarSegundo'])->name('puesto.recuperar.segundo');
Route::get('/puesto/recuperartodos', [PuestoController::class, 'recuperarTodos'])->name('puesto.recuperar.todos');
Route::resource('puesto', PuestoController::class);

Route::get('empleado/recuperar', [EmpleadoController::class, 'recuperar'])->name('empleado.recuperar');
Route::post('empleado/recuperarsegundo', [EmpleadoController::class, 'recuperarSegundo'])->name('empleado.recuperar.segundo');
Route::get('/empleado/recuperartodos', [EmpleadoController::class, 'recuperarTodos'])->name('empleado.recuperar.todos');
Route::resource('empleado', EmpleadoController::class);