<?php


require_once 'vendor/autoload.php';


use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load( dirname(dirname(__DIR__)) . '/.env');

require_once 'configs/database.php';

include ('database/seeders/user_seeder.php');
