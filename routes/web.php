<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'InicioController')->name('inicio');

Auth::routes(['verify' => true]);


//RUTAS PROTEGIDAS
Route::group(['middleware' => ['auth','verified']], function() {

    //VACANTES
    Route::get('/vacantes', 'VacanteController@index')->name('vacantes.index');
    Route::get('/vacantes/create', 'VacanteController@create')->name('vacantes.create');
    Route::post('/vacantes/store', 'VacanteController@store')->name('vacantes.store');
    Route::delete('/vacantes/{vacante}', 'VacanteController@destroy')->name('vacantes.destroy');
    Route::get('/vacantes/{vacante}/edit', 'VacanteController@edit')->name('vacantes.edit');
    Route::put('/vacante/{vacante}', 'VacanteController@update')->name('vacantes.update');

    //SUBIR IMAGENES
    Route::post('/vacantes/imagen', 'VacanteController@imagen')->name('vacantes.imagen');
    Route::post('/vacantes/borrarimagen', 'VacanteController@borrarimagen')->name('vacantes.borrar');

    //CAMBIAR ESTADO DE VACANTE
    Route::post('/vacantes/{vacante}', 'VacanteController@estado')->name('vacantes.estado');

    //NOTIFICACIONES
    Route::get('/notificaciones', 'NotificacionesController')->name('notificaciones');
});

Route::get('/categorias/{categoria}', 'CategoriaController@show')->name('categorias.show');

Route::get('/candidatos/{id}', 'CandidatoController@index')->name('candidatos.index');
Route::post('/candidatos/store', 'CandidatoController@store')->name('candidatos.store');


//MUESTRA VACANTES SIN AUTENTICACION
//el proceso de ruta y controller esta correcto, marca error 404 not found por el orden de las rutas, por eso
//por eso se paso esta ruta para arriba, antes de pedir en vacantes con el comodin {vacante}
//asi ya se logra entrar al metodo de mostrar los resultados de la busqueda
//preferentemente colocar los comodines al final
Route::get('/busqueda/buscar', 'VacanteController@resultados')->name('vacantes.resultados');
Route::post('/busqueda/buscar', 'VacanteController@buscar')->name('vacantes.buscar');
Route::get('/vacantes/{vacante}', 'VacanteController@show')->name('vacantes.show');
//Route::get('/vacantes/buscar', 'VacanteController@resultados')->name('vacantes.resultados');
