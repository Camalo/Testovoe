<?php

class BaseModel{

    function __construct(){
        $this->db = new DataBase();
    }
} 