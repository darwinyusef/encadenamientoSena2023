<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function(){

    Route::get('/prueba', function() {
        // $list = new stdClass();
        // $list->api = "Hola mundo"; 
        // return json_encode($list); 
    
        // $list = json_encode(array("api" => "Hola Mundo")); 
        // return $list; 
    
        $list = json_decode('{ "api": "Hola mundo"}');
        return $list;
    });

/// ------> Se establece  el estudiante
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{uuid}', [StudentController::class, 'show']);
    Route::post('students', [StudentController::class, 'store']);
    Route::put('students/{uuid}/edit', [StudentController::class, 'update'])->name('students.update');
    Route::put('document/{uuid}', [StudentController::class, 'updateDocument']);
    Route::delete('students/{uuid}', [StudentController::class, 'destroy']);


/// ------> Seleccción de cursos
    Route::post('selection/{uuid}', [StudentController::class, 'firstSelected']);
    Route::get('search/{document}', [StudentController::class, 'search_document']);
    
});


