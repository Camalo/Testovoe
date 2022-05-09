<?php

namespace models;
use model\entities;

class StudentModel 
{
    // Выборка всех заданий студента

    private array $students;
    private array $groups;
    private array $tasks;
    private array $studentTasks;
    private array $lessons;
   // private int $studentId;

    public function __construct(array $tasks,array $students){
        $this->tasks = $tasks;
        $this->students = $students;
       
    }

     /**
     * Нахождение всех заданий относящихся к определенному студенту
     * 
     * @param int $studentId id студента
     * @return Task[] массив заданий студента 
     */
    function getStudentTasks($studentId){
        $currentStudent= $this->getCurrentStudent($studentId);
        $this->studentTasks = array();
         // найти все задания студента

         foreach($this->tasks as $task){
            if($task->getStudentId() == $studentId){
                $this->studentTasks[] = $task;
            }
            foreach($currentStudent->getGroups() as $group){
                if($group->getId() == $task->getGroupId()){
                    $this->studentTasks[] = $task;
                }

                foreach($group->getLessons() as $lesson){
                    if($lesson->getId() == $task->getLessonId()){
                        $this->studentTasks[] = $task;
                    }
                }
            }
         }
       return  $this->studentTasks;
    }

    function getCurrentStudent($studentId){
        foreach($this->students as $student)
        {
            if($student->getId() == $studentId){
                return $student;
            }
        }
    }
}