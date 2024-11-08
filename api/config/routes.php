<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');


// Login - Gerar Token
Router::post('/login', 'App\Controller\LoginController@login');

// List User
Router::post('/user', 'App\Controller\UserController@listUser');

// List Users
Router::post('/users', 'App\Controller\UserController@listUsers');

// Create User
Router::post('/user/create', 'App\Controller\UserController@createUser');

// Update User
Router::put('/user/update', 'App\Controller\UserController@updateUser');

// Delete User
Router::delete('/user/delete', 'App\Controller\UserController@deleteUser');

