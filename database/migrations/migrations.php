<?php


require_once 'vendor/autoload.php';


use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load( dirname(dirname(__DIR__)) . '\\.env');

require_once 'configs/database.php';

include ('database\migrations\user_migration.php');
include ('database\migrations\task_migration.php');
