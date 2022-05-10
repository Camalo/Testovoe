<?php

namespace models\entities;

class Task implements \JsonSerializable
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
     * Серилизует свойства объекта в JSON
     * @return mixed
     */
    public function jsonSerialize()
    {
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
     * Get the value of task
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Get the value of status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of studentId
     * @return ?int
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Get the value of lessonId
     * @return ?int
     */
    public function getLessonId()
    {
        return $this->lessonId;
    }

    /**
     * Get the value of groupId
     * @return ?string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }
}
