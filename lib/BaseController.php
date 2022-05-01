<?php

class BaseController{
    function __construct()
    {
        $this->view = new View();
    }

    public function LoadModel($name){
        $path = "model/".$name."Model.php";
        if (file_exists($path)){
            require $path;
            $modelName = $name . "Model";
            $this->model = new $modelName();
        }

    }
}