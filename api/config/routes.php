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



// List Cards
Router::post('/cards/user', 'App\Controller\CardController@listUserCards');

// Create Cards
Router::post('/card/create', 'App\Controller\CardController@createCard');

// Update Cards
Router::put('/card/update', 'App\Controller\CardController@updateCard');

// Delete Cards
Router::delete('/card/delete', 'App\Controller\CardController@deleteCard');

// List All Cards
Router::post('/cards', 'App\Controller\CardController@listCards');

// List All Deleted Cards
Router::post('/cards/deleted', 'App\Controller\CardController@listDeletedCards');



// List Expenses
Router::post('/expenses/card', 'App\Controller\ExpenseController@listCardExpenses');

// Create Expenses
Router::post('/expense/create', 'App\Controller\ExpenseController@createExpense');

// Delete Expenses
Router::delete('/expense/delete', 'App\Controller\ExpenseController@deleteExpense');
