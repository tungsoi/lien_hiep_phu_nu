<?php

use Illuminate\Routing\Router;
use Brazzer\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/** Member */
Route::group([
    'prefix'        => '',
    'namespace'     => 'App\Member\Controllers',
    'middleware'    =>  'web'
], function (Router $router) {
    $router->get('/', 'HomeController@dashboard')->name('member.dashboard');
    $router->get('login', 'LoginController@login')->name('member.login');
    $router->post('postLogin', 'LoginController@postLogin')->name('member.postLogin');
    $router->get('register', 'RegisterController@register')->name('member.register');
    $router->get('logout', 'LoginController@logout')->name('member.logout');
    $router->post('postRegister', 'RegisterController@postRegister')->name('member.postRegister');

    // du thi
    $router->get('exam/{id}', 'HomeController@exam')->name('member.exam');
    $router->post('exam/store', 'HomeController@storeExam')->name('member.storeExam');

});

/** Admin */
Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => 'App\Admin\Controllers',
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('weeks/{id}/answers', 'WeekController@answers')->name('weeks.answers');
    $router->get('weeks/{id}/prizes', 'WeekController@prizes')->name('weeks.prizes');
    $router->get('weeks/export', 'WeekController@export')->name('weeks.export');
    $router->get('weeks/exportAnswer', 'WeekController@exportAnswer')->name('weeks.exportAnswer');

    $router->resources([
        'weeks' =>  'WeekController',
        'members' =>  'MemberController',
        'prizes' =>  'PrizeController',
    ]);
});


