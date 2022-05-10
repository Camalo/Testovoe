<?php
namespace models\entities;

class Load{
    
    private int $taskId;
    private int $studentsCount;
    private int $instructorsCount;
    private $coefficient;
    
    function __construct(int $taskId, int $studentsCount,int $instructorsCount)
    {
        $this->taskId = $taskId;
        $this->studentsCount = $studentsCount;
        $this->instructorsCount = $instructorsCount;
        $this->coefficient = ($this->instructorsCount > 0)?  $this->studentsCount/ $this->instructorsCount: 0;
       
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
     * Get the value of studentsCount
     * @return int
     */ 
    public function getStudentsCount()
    {
        return $this->studentsCount;
    }

    /**
     * Get the value of instructorsCount
     * @return int
     */ 
    public function getInstructorsCount()
    {
        return $this->instructorsCount;
    }

    /**
     * Get the value of coefficient
     */ 
    public function getCoefficient()
    {
        return $this->coefficient;
    }
}