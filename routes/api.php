<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/users/{user}')->group(function (){
    Route::get('/starred', [\App\Http\Controllers\RepositoryController::class,'show']);
    Route::post('/addTags', [\App\Http\Controllers\TagController::class,'adds']);
    Route::get('/search/{tag}', [\App\Http\Controllers\TagController::class,'search']);
    Route::resource('tags', \App\Http\Controllers\TagController::class)->except(["index", "create", "edit", "show"]);
});


//Route::resource('repositories.user',\App\Http\Controllers\RepositoryController::class);
