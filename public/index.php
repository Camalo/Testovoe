<?php
require_once '../vendor/autoload.php';
use \src\App;
use \src\ErrorHandler;
define('URL','https://localhost/testovoe');



//$errorHandler = new ErrorHandler();
ErrorHandler::register();

$app = new App();
