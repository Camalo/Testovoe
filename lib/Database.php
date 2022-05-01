<?php

class Database extends PDO{

    public function __construct(){
        parent::__construct(DBTYPE.':host='.DBHOST.';dbname='.DBNAME.';charset=UTF8',DBUSER,DBPASS);
      
    }
    
}