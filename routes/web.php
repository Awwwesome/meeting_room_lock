<?php


Route::post('/log', 'LogController@createLog');
Route::get('/log', 'LogController@getRoomOccupancy');

Route::get('{any}', function () {
    return view('home');
})->where('any', '.*');;

