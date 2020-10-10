<?php
use Illuminate\Http\Request;


Route::namespace('Api\v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'LoginController@login');
     });
    Route::group(['middleware' => 'auth:api'], function () {


        /*
         * ApiResource routes
         * */
        Route::apiResource('/students', 'StudentController');
        Route::apiResource('/groups', 'GroupController');
        Route::apiResource('/courses', 'CourseController');
        Route::apiResource('/testing', 'TestingController');

        /*
         * Search routes.
         * Example: /search/groups, /search/students
         * */
        Route::prefix('search')->group(function () {
            Route::get('groups', 'GroupController@search');
            Route::get('tests', 'TestingController@search');
        });


        Route::get('groups/students/{group}', 'GroupController@getStudents');
        Route::post('courses/{course}/detach', 'CourseController@detachGroups');
        Route::post('courses/{course}/attach', 'CourseController@attachGroups');

        Route::post('courses/{course}/works', 'WorkController@store');
    });
});
