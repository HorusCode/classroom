<?php
use Illuminate\Http\Request;


Route::namespace('Api\v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'LoginController@login');
     });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('/students', 'StudentController');

        Route::prefix('search')->group(function () {
            Route::get('groups', 'GroupController@search');
        });
    });
});
