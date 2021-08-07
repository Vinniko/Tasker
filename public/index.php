<?php


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../app/App.php';

use App\App;
use Symfony\Component\Finder\Finder;

$finder = new Finder();
$finder->in('../vendor/');

App::run();