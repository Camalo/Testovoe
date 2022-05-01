<?php

class Lesson{
    
    function __construct( $id, $title, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }
}