<?php
namespace src;

use controllers\IndexController as IndexController;

class IndexFactory implements ControllerFactory
{
    public static function Create(): Controller
    {
        return new IndexController();
    }
}