<?php

namespace src;


class ErrorHandler{

    
     public function register(){
        ini_set('display_errors', 'off');
        set_error_handler([$this, 'processError']);
    }

    public function processError($errorNo, $errorStr, $errorFile, $errorLine){
        header("HTTP/1.1 500");
        $log = $errorStr . " file: " . $errorFile . " line: " . $errorLine;
        Logger::Log($log);
        return true;
    }
}

