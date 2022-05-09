<?php

namespace src;

use controllers\IndexController as IndexController;
use controllers\ErrorController as ErrorController;

interface ControllerFactory
{

    public static function Create();
  
}
