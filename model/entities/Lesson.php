<?php

namespace models\entities;

class Lesson
{

    private int $id;
    private string $title;
    private string $description;
    function __construct($id, $title, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the value of id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
