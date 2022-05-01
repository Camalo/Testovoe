<?php

class ErrorController extends BaseController
{

    function __construct()
    {
        parent::__construct();
    }

    public function Index(){
        $this->view->render('error', 'index',[]);
    }
}