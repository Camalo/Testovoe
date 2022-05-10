<?php
namespace models\entities;

class StudentsCount implements \JsonSerializable
{
    
    private int $taskId;
    private int $count;
    
    function __construct(int $taskId, int $count)
    {
        $this->taskId = $taskId;
        $this->count = $count;
    }

    /**
     * Серилизует свойства объекта в JSON
     * @return mixed
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
    /**
     * Get the value of taskId
     * @return int
     */ 
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Get the value of count
     * @return int
     */ 
    public function getCount()
    {
        return $this->count;
    }
}