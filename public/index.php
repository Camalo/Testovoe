<?php
require_once '../vendor/autoload.php';
use \src\App;
use \src\ErrorHandler;
define('URL','https://localhost/testovoe');



$errorHandler = new ErrorHandler();
$errorHandler->register();

$app = new App();
