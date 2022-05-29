<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TopicController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [RegisterController::class, 'register']);


Route::group(['prefix' => 'topics'], function () {
    Route::get('/', [TopicController::class, 'index']);
    Route::get('/{topic}', [TopicController::class, 'show']);
    Route::post('/', [TopicController::class, 'store'])->middleware('auth:api');
    Route::patch('/{topic}', [TopicController::class, 'update'])->middleware('auth:api');
    Route::delete('/{topic}', [TopicController::class, 'destroy'])->middleware('auth:api');
    Route::group(['prefix' => '/{topic}/posts'], function () {
        Route::post('/', [PostController::class, 'store'])->middleware('auth:api');
        Route::patch('/{post}', [PostController::class, 'update'])->middleware('auth:api');
        Route::delete('/{post}', [PostController::class, 'destroy'])->middleware('auth:api');

       Route::group(['prefix' => '/{post}/likes'], function () {
            Route::post('/', [PostLikeController::class,'store'])->middleware('auth:api');
        });
    });
});

