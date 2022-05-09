<?php

namespace models\entities;

class Instructor
{
    private int $id;
    private string $firstName; 
    private string $lastName; 
    private array $tasks;
    private int $tasksCount;
    
    function __construct($id, $firstName, $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the value of tasks
     */ 
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set the value of tasks
     *
     * @return  self
     */ 
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get the value of tasksCount
     */ 
    public function getTasksCount()
    {
        return $this->tasksCount;
    }

    /**
     * Set the value of tasksCount
     *
     * @return  self
     */ 
    public function setTasksCount($tasksCount)
    {
        $this->tasksCount = $tasksCount;

        return $this;
    }
}
