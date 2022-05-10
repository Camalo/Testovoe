<?php
namespace src;
use PDO as PDO;


class Database extends PDO{

    public function __construct(){
        $ini = parse_ini_file('..\config\config.ini');
      
        
        parent::__construct($ini['db_type'].':host='.$ini['db_host'].';dbname='.$ini['db_name'].';charset=UTF8',$ini['db_user'],$ini['db_password']);
      
    }
 
}