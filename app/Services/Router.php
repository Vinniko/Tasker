<?php


namespace App\Services;


use ErrorException;

class Router
{
    private static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public static function route()
    {
        $path = ltrim($_SERVER['REQUEST_URI'], '/');
        $path = explode('?', $path)[0];
        $request_method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($path, self::$routes[$request_method])) {
            $controller = self::$routes[$request_method][$path]['controller'];
            $action = self::$routes[$request_method][$path]['action'];
            $controller = 'App\Http\Controllers\\' . $controller;
            $action = ucfirst($action);

            if (!class_exists($controller)) {
                throw new ErrorException('Controller does not exist');
            }

            $objController = new $controller;

            if (!method_exists($objController, $action)) {
                throw new ErrorException('Action does not exist');
            }

            echo $objController->$action();
        } else {
            die('404'); // заглушка
        }
    }

    public static function get(string $route, string $controller, string $action, string $name = null)
    {
        self::createRoute('GET', $route, $controller, $action, $name);
    }

    public static function post(string $route, string $controller, string $action, string $name = null)
    {
        self::createRoute('POST', $route, $controller, $action, $name);
    }

    public static function put(string $route, string $controller, string $action, string $name = null)
    {
        self::createRoute('PUT', $route, $controller, $action, $name);
    }

    public static function delete(string $route, string $controller, string $action, string $name = null)
    {
        self::createRoute('DELETE', $route, $controller, $action, $name);
    }

    private static function createRoute(string $route_type, string $route, string $controller, string $action,
                                        string $name = null)
    {
        self::$routes[$route_type] += [
            $route => [
                'controller' => $controller,
                'action' => $action,
                'name' => $name,
            ]
        ];
    }
}