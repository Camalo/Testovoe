<?php

namespace src;

use controllers\IndexController as IndexController;
use controllers\IndexController as ErrorController;

class App
{
    const default_path = 'index';
    const error_class = 'src\\ErrorFactory';

    private Controller $controller;

    function __construct()
    {
        
        $url = $this->getUrl();
        $className = 'src\\' . $url[0] . 'Factory';

        $className = (class_exists($className)) ? $className : $this::error_class;


        $this->controller = $className::Create();


        if (isset($url[2]) && method_exists($this->controller, $url[1])) {
            $this->controller->{$url[1]}($url[2]);
        } elseif (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->controller->{$url[1]}();
        } else {
            $this->controller->Index();
        }
    }

    private function getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : self::default_path;
        $url = explode('/', trim($url, '/'));

        return $url;
    }

}
