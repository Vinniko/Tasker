<?php


namespace App;


use App\Services\Router;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    public static function run()
    {
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__) . '\\.env');

        include(dirname(__DIR__) . '\\configs\\database.php');

        include(dirname(__DIR__) . '\\app\\routes\\routes.php');
        Router::route();
    }
}