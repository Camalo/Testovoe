<?php
namespace models\entities;

class Group{
    
    private string $id;
    private array $lessons;
    function __construct(string $id)
    {
        $this->id = $id;
    }
    
    /**
     * Возвращает номер группы id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of lessons
     */ 
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * Set the value of lessons
     *
     * @return  self
     */ 
    public function setLessons($lessons)
    {
        $this->lessons = $lessons;

        return $this;
    }
}