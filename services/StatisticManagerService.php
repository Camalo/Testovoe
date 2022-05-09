<?php

namespace services;

use src\Database;
use models\entities\Task;
use models\entities\Student;
use models\entities\Group;
use models\entities\Instructor;
use models\entities\Lesson;



class StatisticManagerService extends DataBase
{
    private DataBase $db;
    private $tasks;
    private array $students;


    function __construct()
    {
        $this->db = new DataBase();
    }

    public function getInstructors(){
        $stmt = $this->db->query("SELECT `id`, `firstName`, `lastName` FROM `instructors`");
        $stmt->execute();
        $dbRows = $stmt->fetchAll();

        return $this->restructDbRowsToInstructors($dbRows);
    }

    public function restructDbRowsToInstructors(array $dbRows):array
    {
        $instructorTasks = array();

        foreach ($dbRows as $dbItem) {
            $instructor = new Instructor($dbItem['id'],$dbItem['firstName'],$dbItem['lastName']);
            $this->setInstructorTasks($instructor->getId());
            $instructor->setTasks($this->tasks);
            $instructorTasks[] = $instructor;
        }
        return $instructorTasks;
    }

    private function setInstructorTasks($instructor_id){
        $stmt = $this->db->prepare("SELECT `id`, `task`, `status`, `group_id`, `student_id`, `lesson_id` FROM `tasks` 
        JOIN `instructors_tasks` ON `instructors_tasks`.`task_id`= `tasks`.`id`
        WHERE `instructors_tasks`.`instructor_id` = :instructor_id");
        $stmt->execute(array(
            ':instructor_id' => $instructor_id
        ));
        $dbRows = $stmt->fetchAll();
        $this->restructDbRowsToTasks($dbRows);
       // return $this->tasks;
    }
   

    public function restructDbRowsToTasks($dbRows)
    {
        $this->tasks = array();

        foreach ($dbRows as $task) {
            $this->tasks[] = new Task($task['id'], $task['task'], $task['status'], $task['group_id'], $task['student_id'], $task['lesson_id']);
        }
        
    }
}