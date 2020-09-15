<?php


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

Route::post('auth/login', 'Api\v1\LoginController@login');
Route::get('/logout', 'Api\v1\LoginController@logout')->name('logout');
Route::view('/login','pages/auth/login')->name('login');

Route::middleware('auth')->group(function () {
    Route::view('/','pages/index')->name('home');
    Route::group(['middleware' => 'role:teacher', 'as' => 'web.'], function () { // TODO: add admin role
        Route::view('/people/create', 'pages/people/create')->name('people.create');
        Route::view('/people', 'pages/people/index')->name('people.index');

        Route::view('/groups', 'pages/groups/index')->name('groups.index');

        Route::view('/courses', 'pages/courses/index')->name('courses.index');

        Route::view('/courses/{id}', 'pages/courses/show')->name('courses.show')->name('courses.detach');
    });
});

