<?php
namespace models\entities;

class StudentsCount{
    
    private int $taskId;
    private int $count;
    
    function __construct(int $taskId, int $count)
    {
        $this->taskId = $taskId;
        $this->count = $count;
    }

    /**
     * Get the value of taskId
     */ 
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Get the value of count
     */ 
    public function getCount()
    {
        return $this->count;
    }
}