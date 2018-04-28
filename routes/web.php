<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    $sheepfolds = App\Sheepfold::with('sheeps')->get();
    $day = Session::get('day') ? Session::get('day') : 0;
    return view('game', compact('sheepfolds', 'day'));
});

Route::get('/sheepfolds', function () {
    return App\Sheepfold::with('sheeps')->get();
});

Route::get('/day', function () {
    $day = Session::get('day') ? Session::get('day') : 0;
    return $day;
});

Route::post('/sheeps', 'SheepController@create');
Route::post('/sheeps/{day}', 'SheepController@new');
Route::post('/sheeps/{day}/delete', 'SheepController@delete');
Route::post('/history', 'SheepController@history')->name('history');
