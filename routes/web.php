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
    Route::group(['middleware' => 'role:teacher'], function () { // TODO: add admin role
        Route::view('/people/add', 'pages/people/add')->name('add_people');
        Route::view('/people/show', 'pages/people/show')->name('show_people');
        Route::view('/groups', 'pages/groups/index')->name('groups');
        Route::view('/courses', 'pages/courses/index')->name('courses');
    });
});

