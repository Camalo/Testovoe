<?php
namespace models\entities;

class Student{
    
    private int $id;
    private string $firstName;
    private string $lastName;

    private array $groups;
    
    function __construct( $id, $firstName, $lastName)
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
     * Get the value of first_name
     */ 
    public function getFirst_name()
    {
        return $this->firstName;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLast_name()
    {
        return $this->lastName;
    }

    /**
     * Get the value of groups
     */ 
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set the value of groups
     *
     * @return  self
     */ 
    public function setGroups($groups)
    {
        $this->groups = $groups;

        return $this;
    }
}