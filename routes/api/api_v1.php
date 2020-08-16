<?php
use Illuminate\Http\Request;


Route::namespace('Api\v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'LoginController@login');
    });
});
