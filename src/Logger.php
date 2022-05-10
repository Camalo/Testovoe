<?php
namespace src;

class Logger {

    const FILE = "../server.log";

    public static function Log(string $log){
        $currentTime = date('Y-m-d', time());
        $log = $currentTime . " " . $log ."\n";
        file_put_contents(self::FILE, $log, FILE_APPEND| LOCK_EX);
    }
}