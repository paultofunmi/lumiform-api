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
Route::prefix('auth')->group(function () {
    Route::post('/register', 'AuthApiController@register')->name('register');
    Route::post('/login', 'AuthApiController@login')->name('login');
    Route::get('/logout', 'AuthApiController@logout')->name('logout')->middleware('auth:api');
});

Route::prefix('quiz')->group(function () {
    Route::get('search', 'QuizApiController@searchMoviesByTerm')->middleware('auth:api');
    Route::post('score', 'QuizApiController@scoreQuiz')->middleware('auth:api');
    Route::get('results', 'QuizApiController@quizResults')->middleware('auth:api');
});
