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

        $this->view->render('index', 'index', [
            'tasksOfStudent' => $studentTasks,
            'students' => $students
        ]);
    }
    /**
     * Нахождение количества студентов выполняющих определенное задание
     * 
     */
    public function getStudentsCount()
    {
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();

        $this->model = new InstructorModel($students);
        $studentCount = $this->model->getStudentsCount(1, $tasks);

        $this->view->render('index', 'studentsCount', [
            'studentsCount' => $studentCount,
            'tasks' => $tasks
        ]);
    }
    /**
     * Нахождение студентов и групп выполняющих определенное задание
     * 
     * @return Student[] объект 
     */
    public function getListOfGroupsStudents()
    {
        
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();


        $this->model = new InstructorModel($students);
        $taskStudents = $this->model->getTaskStudents(1, $tasks);

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
    public function getTaskLoadsStatistic()
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
    public function getCriticalLoadedStatistic()
    {
        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();
        $this->model = new InstructorModel($students);
        $studentCounts = array();
        foreach ($tasks as $task) {

            $studentCounts[$task->getId()] = $this->model->getStudentsCount($task->getId(), $tasks);
        }

        $this->service = new StatisticManagerService();
        $instructors = $this->service->getInstructors();
        $this->model = new StatisticModel($instructors);
        $loads = $this->model->getCriticalLoadedStatistic($tasks, $studentCounts);


        $this->view->render('index', 'taskStatistikCalculation', [
            'loads' => $loads
        ]);
    }

    /**
     * Нахождение студентов для определенного занятия
     * 
     */
    public function getLessonStudents()
    {
        //Вывод списка студентов для конкретного занятия
        $this->service = new StudentsManagerService();

        $students = $this->service->getStudents();
        $lessons = $this->service->getLessons();
        $this->model = new InstructorModel($students);

        $lessonStudents = $this->model->getLessonStudents(3);


        $this->view->render('index', 'listOfStudents', [
            'students' => $lessonStudents,
            'lessons' => $lessons
        ]);
    }


    /**
     * Нахождение всех заданий относящихся к определенному студенту
     * в ответ на Ajax запрос
     */
    public function updateTaskOfStudent()
    {

        if (isset($_POST['student'])) {

            $studentId = $_POST['student'];
            $this->service = new StudentsManagerService();

            $tasks = $this->service->getTasks();
            $students = $this->service->getStudents();

            $this->model = new StudentModel($tasks, $students);

            $studentTasks = $this->model->getStudentTasks($studentId);

            echo json_encode(['status' => 'success', 'data' => $studentTasks]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Нахождение количества студентов выполняющих определенное задание
     * в ответ на Ajax запрос
     * 
     */
    public function updateStudentsCount()
    {
        if (isset($_POST['task'])) {
            $taskId = $_POST['task'];

            $this->service = new StudentsManagerService();

            $tasks = $this->service->getTasks();
            $students = $this->service->getStudents();

            $this->model = new InstructorModel($students);
            $studentCount = $this->model->getStudentsCount($taskId, $tasks);
            echo json_encode(['status' => 'success',  'data' => $studentCount]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Нахождение студентов для определенного занятия
     * в ответ на Ajax запрос
     */
    public function updateLessonStudents()
    {
        if (isset($_POST['lesson'])) {
            $lessonId = $_POST['lesson'];
            $this->service = new StudentsManagerService();

            $students = $this->service->getStudents();
            $this->model = new InstructorModel($students);

            $lessonStudents = $this->model->getLessonStudents($lessonId);
            echo json_encode(['status' => 'success', 'data' => $lessonStudents]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Нахождение студентов и групп выполняющих определенное задание
     * в ответ на Ajax запрос
     */
    public function updateListOfGroupsStudents()
    {
        if (isset($_POST['task'])) {
            $taskId = $_POST['task'];
            $this->service = new StudentsManagerService();

            $tasks = $this->service->getTasks();
            $students = $this->service->getStudents();
    
    
            $this->model = new InstructorModel($students);
            $taskStudents = $this->model->getTaskStudents($taskId, $tasks);
            echo json_encode(['status' => 'success', 'taskStudents' => $taskStudents, 'task' => $taskId]);
        } else
            echo json_encode(['status' => 'error']);

        $this->service = new StudentsManagerService();

        $tasks = $this->service->getTasks();
        $students = $this->service->getStudents();


        $this->model = new InstructorModel($students);
        $taskStudents = $this->model->getTaskStudents(1, $tasks);
    }
}
