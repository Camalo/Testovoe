<?php

namespace controllers;

use view\View;
use models\Instructor;
use models\InstructorModel;
use models\StatisticModel;
use models\StudentModel;
use services\StudentsManagerService;
use services\StatisticManagerService;
use src\Controller;

class IndexController implements Controller
{
    private $model;
    private $service;
    private $view;
    function __construct()
    {
       $this->view = new View();
    }

    /**
     * Нахождение всех заданий относящихся к определенному студенту
     */
    public function Index()
    {

        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();

        $this->model = new StudentModel($tasks, $students);

        $studentTasks = $this->model->getStudentTasks(1);

        $this->view->render('index', 'index',[
            'tasksOfStudent' => $studentTasks,
            'students' => $students
        ]);
    }
    /**
     * Нахождение количества студентов выполняющих определенное задание
     * 
     */
    public function StudentsCount()
    {
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();

        $this->model = new InstructorModel($students);
        $studentCount = $this->model->getStudentsCount(1, $tasks);
    
        $this->view->render('index', 'studentsCount', [
            'studentsCount' =>$studentCount,
            'tasks' => $tasks
        ]);
    }
    /**
     * Нахождение студентов и групп выполняющих определенное задание
     * 
     * @return Student[] объект 
     */
    public function ListOfGroupsStudents()
    {
        //Выборка для задания списка групп и студентов;
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();
        //$groups=$this->service->getGroups();

        $this->model = new InstructorModel($students);
        $taskStudents = $this->model->getTaskStudents(1, $tasks);
        //var_dump($taskStudents);
        $this->view->render('index', 'selectGroupsStudents', [
            'students' => $taskStudents,
            'tasks' => $tasks
        ]);
    }

     /**
     * Расчёт нагрузки проверяющих
     * Нахождение информации о проверяющих и количестве заданий которые необходимо проверить
     * 
     */
    public function LoadCalculationOfInspectors()
    {
        $this->service = new StatisticManagerService();
        $instructors = $this->service->getInstructors();

        $this->model = new StatisticModel($instructors);
        $instructors = $this->model->getTaskLoadsStatistic();



        $this->view->render('index', 'loadCalculationOfInspectors', [
            'instructors' => $instructors
        ]);
    }

    /**
     * Нахождение информации о задании, количестве студентов выполняющих задание и 
     * количестве проверяющих задание 
     * 
     */
    public function TaskStatistikCalculation()
    {
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();
        $this->model = new InstructorModel($students);
        $studentCounts =array();
        foreach($tasks as $task){

            $studentCounts[$task->getId()] = $this->model->getStudentsCount($task->getId(), $tasks);
        }

        $this->service = new StatisticManagerService();
        $instructors = $this->service->getInstructors();
        $this->model = new StatisticModel($instructors);
        $loads = $this->model->getCriticalLoadedStatistic($tasks,$studentCounts);
        
        // var_dump($loads);

        $this->view->render('index', 'taskStatistikCalculation', [
            'loads' => $loads
        ]);
    }
    public function ListOfStudents()
    {
        //Вывод списка студентов для конкретного занятия
        $this->service = new StudentsManagerService();

        $students = $this->service->getStudents();
        $lessons = $this->service->getLessons();
        $this->model = new InstructorModel($students);

        $lessonStudents = $this->model->getLessonStudents(3);

        // var_dump($lessonStudents);

        $this->view->render('index', 'listOfStudents', [
            'students' => $lessonStudents,
            'lessons' => $lessons
        ]);
    }


    //ОБНОВЛЕНИЕ
    public function updateTaskOfStudent()
    {
        $this->model->updateTaskOfStudent();
    }

    public function updateStudentsCount()
    {
        $this->model->updateStudentsCount();
    }
    public function updateStudentsOfTask()
    {
        $this->model->updateStudentsOfTask();
    }

    public function updateListOfStudents()
    {
        $this->model->updateStudentsOfClass();
    }
    public function updateListOfGroupsStudents()
    {
        $this->model->updateListOfGroupsStudents();
    }
}
