<?php

use Illuminate\Routing\Router;
use Brazzer\Admin\Facades\Admin;
use Illuminate\Support\Facades\Route;

/** Member */
Route::group([
    'prefix'        => '',
    'namespace'     => 'App\Admin\Controllers',
    'middleware'    =>  'web'
], function (Router $router) {
    $router->get('/', 'MemberController@dashboard')->name('member.dashboard')->middleware('member-dashboard');
    $router->get('login', 'MemberAuthController@getLogin')->name('member.login')->middleware('member-login');
    $router->post('postLogin', 'MemberAuthController@postLogin')->name('member.postLogin');
    $router->get('register', 'MemberAuthController@register')->name('member.register');
    $router->get('logout', 'MemberAuthController@getLogout')->name('member.getLogout');
    $router->post('postRegister', 'MemberAuthController@postRegister')->name('member.postRegister');

    // du thi
    Route::group([
        'middleware'    =>  'exam-auth'
    ], function (Router $router) {
        $router->get('exam/{id}', 'MemberController@exam')->name('member.exam');
        $router->post('exam/store', 'MemberController@storeExam')->name('member.storeExam');
    });

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

    $router->resources([
        'weeks' =>  'WeekController',
        'members' =>  'MemberController'
    ]);
});


