<?php

namespace services;

use src\Database;
use models\entities\Task;
use models\entities\Student;
use models\entities\Group;
use models\entities\Lesson;



class StudentsManagerService extends DataBase
{
    private DataBase $db;
    private $tasks;
    private array $students;


    function __construct()
    {
        $this->db = new DataBase();
    }
    public function getTasks()
    {
      
        $stmt = $this->db->query("SELECT `id`, `task`, `status`, `group_id`, `student_id`, `lesson_id` FROM `tasks`");
        $stmt->execute();
        $dbRows = $stmt->fetchAll();
        $this->restructDbRowsToTasks($dbRows);
        return $this->tasks;
    }

    public function restructDbRowsToTasks($dbRows)
    {
        $this->tasks = array();

        foreach ($dbRows as $task) {
            $this->tasks[] = new Task($task['id'], $task['task'], $task['status'], $task['group_id'], $task['student_id'], $task['lesson_id']);
        }
    }

    public function getStudents(): array
    {
        $stmt = $this->db->query("SELECT `id`, `firstName`, `lastName` FROM `students`");
        $stmt->execute();
        $dbRows = $stmt->fetchAll();
        $this->restructDbRowsToStudents($dbRows);
        return $this->students;
    }

    public function restructDbRowsToStudents(array $dbRows)
    {
        $this->students = array();

        foreach ($dbRows as $dbItem) {
            $student = new Student($dbItem['id'], $dbItem['firstName'], $dbItem['lastName']);
            $groups = $this->getStudentGroups($student->getId());
            $student->setGroups($groups);
            $this->students[] = $student;
        }
    }
    public function getStudentGroups(int $studentId): array
    {
        $stmt = $this->db->prepare("SELECT `group_id` FROM `groups_students` WHERE student_id = :student_id ");
        $stmt->execute(array(
            ':student_id' => $studentId
        ));
        $dbRows = $stmt->fetchAll();

        return $this->restructDbRowsToStudentGroups($dbRows);
    }
    public function getGroups(): array
    {
        $stmt = $this->db->query("SELECT `group_id` FROM `groups_students` WHERE student_id = :student_id ");
        $stmt->execute();
        $dbRows = $stmt->fetchAll();

        return $this->restructDbRowsToStudentGroups($dbRows);
    }

    public function restructDbRowsToStudentGroups(array $dbRows):array
    {
        $studentGroups = array();
        foreach ($dbRows as $dbItem) {
            $group = new Group($dbItem['group_id']);
            $lessons = $this->getGroupLessons($group->getId());
            $group->setLessons($lessons);
            $studentGroups[] = $group;
        }
        return $studentGroups;
    }
    public function getGroupLessons(string $groupId): array
    {
        $stmt = $this->db->prepare("SELECT `id`, `title`, `description` FROM `groups_lessons` 
        JOIN `lessons` ON `lessons`.`id` = `groups_lessons`.`lesson_id`
        WHERE `group_id`= :group_id");
        $stmt->execute(array(
            ':group_id' => $groupId
        ));
        $dbRows = $stmt->fetchAll();

        return $this->restructDbRowsToGroupLessons($dbRows);
    }

    public function getLessons(): array
    {
        $stmt = $this->db->query("SELECT `id`, `title`, `description` FROM `lessons`");
        $stmt->execute();
        $dbRows = $stmt->fetchAll();

        return $this->restructDbRowsToGroupLessons($dbRows);
    }
    public function restructDbRowsToGroupLessons(array $dbRows):array
    {
        $groupLessons = array();
        foreach ($dbRows as $dbItem) {
            $lesson = new Lesson($dbItem['id'],$dbItem['title'],$dbItem['description']);
             $groupLessons[] = $lesson;
        }
        return $groupLessons;
    }
}
