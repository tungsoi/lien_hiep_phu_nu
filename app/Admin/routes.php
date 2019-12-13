<?php

use Illuminate\Routing\Router;
use Brazzer\Admin\Facades\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => 'App\Admin\Controllers',
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resources([
        'weeks' =>  'WeekController'
    ]);
});
