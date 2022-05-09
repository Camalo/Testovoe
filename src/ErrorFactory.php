<?php
namespace src;

use controllers\ErrorController as ErrorController;

class ErrorFactory implements ControllerFactory
{
    public static function Create(): Controller
    {
        return new ErrorController();
    }
}