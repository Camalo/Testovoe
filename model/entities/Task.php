<?php

namespace models\entities;

class Task
{

    private int $id;
    private string $task;
    private string $status;
    private ?string $groupId;
    private ?int $studentId;
    private ?int $lessonId;

    function __construct(int $id, string $task, string $status, ?string $groupId, ?int $studentId, ?int $lessonId)
    {
        $this->id = $id;
        $this->task = $task;
        $this->status = $status;
        $this->groupId = $groupId;
        $this->studentId = $studentId;
        $this->lessonId = $lessonId;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of studentId
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Get the value of lessonId
     */
    public function getLessonId()
    {
        return $this->lessonId;
    }

    /**
     * Get the value of groupId
     */
    public function getGroupId()
    {
        return $this->groupId;
    }
}
