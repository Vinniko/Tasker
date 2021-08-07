<?php


use App\Services\Router;

Router::get('', 'TaskController', 'index');
Router::get('home', 'TaskController', 'index');
Router::get('task/create', 'TaskController', 'create');
Router::get('task/update', 'TaskController', 'update');
Router::get('login', 'AuthController', 'loginForm');
Router::get('logout', 'AuthController', 'logout');

Router::post('task/store', 'TaskController', 'store');
Router::post('task/edit', 'TaskController', 'edit');
Router::post('login', 'AuthController', 'login');