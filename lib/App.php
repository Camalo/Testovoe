<?php

class App
{
    const default_path = 'index';

    private $file;

    function __construct()
    {
       
       $url = $this->getUrl();
        //если имя файла в url указано неправильно 
        // или имя метода в url указано неправильно returns false
        if(!$this->IsCorrectPath($url)){
            require "controller/errorController.php";
            $controller = new ErrorController();
            $controller->Index();
            return false;
        }
        
     
        require_once $this->file;
     
        $controllerName = $url[0].'Controller';
        $controller = new $controllerName;
      
        $controller->loadModel($url[0]);
        
        if (isset($url[2]) && method_exists($controller, $url[1])) {
            $controller->{$url[1]}($url[2]);
        } elseif (isset($url[1]) && method_exists($controller, $url[1])) {
            $controller->{$url[1]}();
        } else {
            $controller->Index();
        }
        
    }

    private function getUrl(){
        $url = isset($_GET['url']) ? $_GET['url'] : self::default_path;
        $url = explode('/',trim($url, '/'));
        $url[0]= $url[0];
        // print_r($url);
        return $url;
    }

    private function IsCorrectPath(array $url){
        $this->file =  "controller/" . $url[0] . "Controller.php";
        if (!file_exists($this->file)) return false;
        if (!isset($url[1])) return true;

        $controllerName = $url[0].'Controller';
        require_once $this->file;
        return method_exists(new  $controllerName, $url[1]);
    }
}
