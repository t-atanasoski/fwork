<?php
define('ROOT', 		dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', 		ROOT . 'app' . DIRECTORY_SEPARATOR);
define('PUB', 		ROOT . 'public' . DIRECTORY_SEPARATOR);

ini_set('display_errors', 1);

require ROOT . 'vendor/autoload.php';
if (file_exists(ROOT . '.env')) {
	Dotenv::load(ROOT);
}

date_default_timezone_set( 'EST5EDT' );

$argv = isset($argv) ? $argv : array();

Fwork\Application::init($argv);