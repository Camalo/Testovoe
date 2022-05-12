<?php

namespace src;


class ErrorHandler{

    
    static public function register(){
        ini_set('display_errors', 'off');
        set_error_handler([self::class, 'processError']);
    }

    static public function processError($errorNo, $errorStr, $errorFile, $errorLine){
        header("HTTP/1.1 500");
        $log = $errorStr . " file: " . $errorFile . " line: " . $errorLine;
        Logger::Log($log);
        return true;
    }
}

