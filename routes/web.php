<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/users', 'UserController@index');
$router->get('/user/login', 'UserController@getuserLogin');
$router->get('/user/{id}', 'UserController@show');
$router->post('/user', 'UserController@store');
$router->put('/user/{id}', 'UserController@update');
$router->delete('/user/{id}', 'UserController@destroy');

$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/logout', 'AuthController@logout');
