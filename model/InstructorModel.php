<?php
// use model\entities;
namespace models;

use models\entities\StudentsCount;



class InstructorModel
{
    // Выборка всех заданий студента

    private array $students;
    private array $tasks;
    private int $taskId;

    public function __construct(array $students)
    {
        $this->students = $students;
    }

    /**
     * Нахождение количества студентов выполняющих определенное задание
     * 
     * @param int $taskId id задания
     * @return StudentsCount объект 
     */
    public function getStudentsCount(int $taskId, array $tasks)
    {
        $this->tasks = $tasks;
        $studentsForTask = $this->getTaskStudents($taskId, $this->tasks);

        $studentsCount = new StudentsCount($taskId, count($studentsForTask));

        return $studentsCount;
    }

    /**
     * Нахождение студентов и групп выполняющих определенное задание
     * 
     * @return Student[] объект 
     */
    public function getTaskStudents(int $taskId,array $tasks): array
    {
        $this->tasks = $tasks;
        $this->taskId = $taskId;
        $studentsForTask = array();
        $currentTask = $this->getCurrentTask();
        foreach ($this->students as $student) {
            if ($student->getId() == $currentTask->getStudentId()) {
                $studentsForTask[] = $student;
            }
            foreach ($student->getGroups() as $studentGroup) {
                if ($studentGroup->getId() == $currentTask->getGroupId()) {
                    $studentsForTask[] = $student;
                }
                foreach ($studentGroup->getLessons() as $lesson) {
                    if ($lesson->getId() == $currentTask->getLessonId()) {
                        $studentsForTask[] = $student;
                    }
                }
            }
        }
        return  $studentsForTask;
    }
    public function getLessonStudents($lessonId)
    {
        $lessonStudents = array();

        foreach ($this->students as $student) {

            foreach ($student->getGroups() as $group) {

                foreach ($group->getLessons() as $lesson) {

                    if ($lesson->getId() == $lessonId)
                        $lessonStudents[] = $student;
                }
            }
        }

        return $lessonStudents; 
    }
    private function getCurrentTask()
    {
        foreach ($this->tasks as $task) {
            if ($task->getId() == $this->taskId) {
                return $task;
            }
        }
    }
}
