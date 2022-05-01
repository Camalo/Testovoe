<?php

class IndexController extends BaseController
{

    function __construct()
    {
        parent::__construct();
        $this->defaultId = 1;
       
    }

    public function Index()
    {
        $this->view->render('index', 'index',[
            'tasksOfStudent' =>$this->model->getTaskOfStudent(1),
            'students' => $this->model->getListOfStudents(),
            'currentStudent' => $this->defaultId
        ]);
    }
    //
    public function StudentsCount()
    {
        $this->view->render('index', 'studentsCount',[
            'studentsCount' =>$this->model->getStudentCount(1),
            'tasks' => $this->model->getListOfTasks(),
            'currentTask' => $this->defaultId
        ]);
    }
    public function ListOfGroupsStudents()
    {
        $this->view->render('index', 'selectGroupsStudents',[
            'students' =>$this->model->getStudentsOfTask(1),
            'groups' =>$this->model->getGroupsOfTask(1),
            'currentTask' => $this->defaultId,
            'tasks' => $this->model->getListOfTasks()
        ]);
    }
  
    public function LoadCalculationOfInspectors()
    {
        $this->view->render('index', 'loadCalculationOfInspectors',[
            'loads' =>$this->model->getLoadOfInspectors()
        ]);
    }
    public function TaskStatistikCalculation()
    {
        $this->view->render('index', 'taskStatistikCalculation',[
            'taskStatistik' =>$this->model->getTaskStatistik()
        ]);
    }
    public function ListOfStudents(){
       
        $this->view->render('index', 'listOfStudents',[
            'students' =>$this->model->getStudentsOfClass(1),
            'lessons' => $this->model->getListOfLessons()
        ]);
    }

   
    //ОБНОВЛЕНИЕ
    public function updateTaskOfStudent(){
        $this->model->updateTaskOfStudent();
    }

    public function updateStudentsCount(){
        $this->model->updateStudentsCount();
    }
    public function updateStudentsOfTask(){
        $this->model->updateStudentsOfTask();
    }

    public function updateListOfStudents(){
        $this->model->updateStudentsOfClass();
    }
    public function updateListOfGroupsStudents(){
        $this->model->updateListOfGroupsStudents();
    }
}
