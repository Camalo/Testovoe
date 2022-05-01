<?php

class Task{
    
    function __construct( $id, $task, $status)
    {
        $this->id = $id;
        $this->task = $task;
        $this->status = $status;
       
    }
}