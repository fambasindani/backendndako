<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TypeCompteController;
use App\Http\Controllers\TypeProprieteController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\ProprieteController;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();



Route::get('/salut', function () {
    return response()->json(['message' => 'Salut Pierre !!!']);
});






Route::post('/utilisateurs', [UtilisateurController::class, 'create_utilisateur']);
Route::get('/utilisateurs', [UtilisateurController::class, 'getUtilisateurs']);




//Route pour Authentification



Route::post('/login', [AuthController::class, 'login']);


//Route pour compte


Route::post('/compte', [TypeCompteController::class, 'create_compte']);
Route::get('/compte', [TypeCompteController::class, 'getcompte']);





// 🔍 Routes pour type_proprietes
Route::get('/type-proprietes', [TypeProprieteController::class, 'get_propriete']);
Route::post('/type-proprietes', [TypeProprieteController::class, 'create_propriete']);
Route::get('/type-proprietes/{id}', [TypeProprieteController::class, 'edit']);
Route::put('/type-proprietes/{id}', [TypeProprieteController::class, 'update_propriete']);
Route::delete('/type-proprietes/{id}', [TypeProprieteController::class, 'delete_propriete']);





//routes pour province
Route::get('/provinces', [ProvinceController::class, 'get_province']);
Route::post('/provinces', [ProvinceController::class, 'create_province']);
Route::get('/provinces/{id}', [ProvinceController::class, 'edit_province']);
Route::put('/provinces/{id}', [ProvinceController::class, 'update_province']);
Route::delete('/provinces/{id}', [ProvinceController::class, 'delete_province']);


// routes pour commune
Route::get('/communes', [CommuneController::class, 'get_commune']);
Route::post('/communes', [CommuneController::class, 'create_commune']);
Route::get('/communes/{id}', [CommuneController::class, 'edit_commune']);
Route::put('/communes/{id}', [CommuneController::class, 'update_commune']);
Route::delete('/communes/{id}', [CommuneController::class, 'delete_commune']);




//routes pour ville
Route::get('/villes', [VilleController::class, 'get_villes']);
Route::post('/villes', [VilleController::class, 'create_ville']);
Route::get('/villes/{id}', [VilleController::class, 'edit_ville']);
Route::put('/villes/{id}', [VilleController::class, 'update_ville']);
Route::delete('/villes/{id}', [VilleController::class, 'delete_ville']);




//routes pour proprietés
Route::get('/proprietes', [ProprieteController::class, 'get_proprietes']);
Route::post('/proprietes', [ProprieteController::class, 'create_propriete']);
Route::get('/proprietes/{id}', [ProprieteController::class, 'edit_propriete']);
Route::put('/proprietes/{id}', [ProprieteController::class, 'update_propriete']);
Route::delete('/proprietes/{id}', [ProprieteController::class, 'delete_propriete']);

Route::get('/proprieteall', [ProprieteController::class, 'getallproprietes']);
Route::get('/proprieteall/{id}', [ProprieteController::class, 'getallproprietesId']);








