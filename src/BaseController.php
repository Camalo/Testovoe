<?php

namespace lib;

// use models;
use view\View as View;


class BaseController{

    function __construct()
    {
        // $this->view = new View();
    }

    // public function LoadModel($name){
    //     $path = "model/".$name."Model.php";
    //     if (file_exists($path)){
    //         // require $path;
    //         $modelName = "\models\\" .$name . "Model";
    //         $this->model = new $modelName();
    //         // $this->model = new IndexModel();
    //     }

    // }
}