<?php

namespace src;

require 'IndexFactory.php';

use controllers\IndexController as IndexController;
use controllers\IndexController as ErrorController;

class App
{
    const default_path = 'index';
    const error_class = 'src\\ErrorFactory';

    private ControllerFactory $factory;
    private Controller $controller;


    //private $file;

    function __construct()
    {

        $url = $this->getUrl();
        $className = 'src\\' . $url[0] . 'Factory';

        $className = (class_exists($className)) ? $className : $this::error_class;


        $controller = $className::Create();


        if (isset($url[2]) && method_exists($controller, $url[1])) {
            $controller->{$url[1]}($url[2]);
        } elseif (isset($url[1]) && method_exists($controller, $url[1])) {
            $controller->{$url[1]}();
        } else {
            $controller->Index();
        }
    }

    private function getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : self::default_path;
        $url = explode('/', trim($url, '/'));

        return $url;
    }

    // private function IsCorrectPath(array $url){
    //     $this->file =  "controller/" . $url[0] . "Controller.php";
    //     if (!file_exists($this->file)) return false;
    //     if (!isset($url[1])) return true;

    //    // $controllerName = $url[0].'Controller';

    //     // require_once $this->file;
    //     return method_exists(new  IndexController, $url[1]);
    // }
}
