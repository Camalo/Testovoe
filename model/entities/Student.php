<?php
namespace models\entities;

class Student implements \JsonSerializable
{
    
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
     * Серилизует свойства объекта в JSON
     * @return mixed
     */
    public function jsonSerialize():mixed    {
        $vars = get_object_vars($this);

        return $vars;
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
     * Get the value of first_name
     * @return string
     */ 
    public function getFirst_name()
    {
        return $this->firstName;
    }

    /**
     * Get the value of last_name
     * @return string
     */ 
    public function getLast_name()
    {
        return $this->lastName;
    }

    /**
     * Get the value of groups
     * @return array
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