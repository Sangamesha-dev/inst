<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/students', 'StudentController');
    $router->resource('/courses', 'CourseController');
    $router->resource('/semesters', 'SemesterController');
    $router->resource('/subjects', 'SubjectController');
    $router->resource('/branches', 'BranchController');

});
