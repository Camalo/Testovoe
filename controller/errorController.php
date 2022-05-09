<?php
namespace controllers;
use src\Controller;
use view\View;

class ErrorController implements Controller
{
    private $view;
    
    function __construct()
    {
        $this->view = new View();
    }

    public function Index(){
        $this->view->render('error', 'index',[]);
    }
}