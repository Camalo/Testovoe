<?php
// use model\entities;
namespace models;
use lib\BaseModel as BaseModel;
use PDO as PDO;
use stdClass as StdClass;

class IndexModel extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }

    
    /**
     * Нахождение всех студентов для вывода в выпадающий список
     * 
     * @return Student[] массив студентов 
     */
    public function getListOfStudents()
    {
        $stmt = $this->db->query("SELECT `students`.`id`, `students`.`firstName`, `students`.`lastName` FROM  `students`");
        $stmt->setFetchMode(PDO::FETCH_NUM);

        $data = $stmt->fetchAll();

        $students = array();

        foreach ($data as $item) {

            $students[] = new Student($item[0], $item[1], $item[2]);
        }

        return $students;
    }

     /**
     * Нахождение всех заданий для вывода в выпадающий список
     * 
     * @return Task[] массив заданий 
     */
    public function getListOfTasks()
    {
        $stmt = $this->db->query("SELECT `tasks`.`id`, `tasks`.`task`, `tasks`.`status`  FROM  `tasks`");
        $stmt->setFetchMode(PDO::FETCH_NUM);

        $data = $stmt->fetchAll();

        $tasks = array();

        foreach ($data as $item) {

            $tasks[] = new Task($item[0], $item[1], $item[2]);
        }
        // var_dump($tasks);
        return $tasks;
    }
    
    /**
     * Нахождение всех заданий относящихся к определенному студенту
     * 
     * @param int $studentId id студента
     * @return Task[] массив заданий студента 
     */
    public function getTaskOfStudent($studentId)
    {
        $stmt = $this->db->prepare("SELECT `tasks`.`id`, `tasks`.`task`, `tasks`.`status`  FROM `tasks` JOIN `students` ON `tasks`.`student_id` = `students`.`id` WHERE `students`.`id` = :student_id  UNION  SELECT `tasks`.`id`, `tasks`.`task`, `tasks`.`status` FROM `tasks` JOIN `groups` ON `groups`.`id`=`tasks`.`group_id` JOIN `groups_students` ON `groups_students`.`group_id` = `groups`.`id` JOIN `students` ON `students`.`id` = `groups_students`.`student_id` WHERE `students`.`id` =  :student_id");
        $stmt->execute(array(
            ':student_id' => $studentId
        ));
        $stmt->setFetchMode(PDO::FETCH_NUM);


        $data = $stmt->fetchAll();

        $tasks = array();

        foreach ($data as $item) {

            $tasks[] = new Task($item[0], $item[1], $item[2]);
        }

        return $tasks;
        //TO DO: tasks of student`s group
    }

    /**
     * Нахождение количества студентов выполняющих определенное задание
     * 
     * @param int $taskId id задания
     * @return StdClass объект 
     */
    public function getStudentCount($task_id)
    {
        
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM (
    
            (SELECT `students`.`id` FROM `students`
            JOIN `groups_students` ON `groups_students`.`student_id` = `students`.`id`
            JOIN `groups` ON `groups`.`id` = `groups_students`.`group_id`
            JOIN `tasks` ON `groups`.`id` = `tasks`.`group_id`
            WHERE `tasks`.`id` = :task_id)
            UNION
            (SELECT `students`.`id` FROM `students`
            JOIN `tasks` ON `tasks`.`student_id` = `students`.`id` WHERE `tasks`.`id` = :task_id)
            ) AS T");

        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(array(
            ':task_id' => $task_id
        ));
        $data = $stmt->fetchAll();

        $studentsCount = new stdClass();
        $studentsCount->task_id = $task_id;
        $studentsCount->count = $data[0][0];

        return $studentsCount;
    }


   
    /**
     * Нахождение студентов выполняющих определенное задание
     * 
     * @param int $taskId id задания
     * @return Student[] массив студентов  
     */
    public function getStudentsOfTask($task_id)
    {
        
        $stmt = $this->db->prepare("SELECT `students`.`id`, `students`.`firstName`, `students`.`lastName` FROM `tasks` JOIN `students` ON `students`.`id`=`tasks`.`student_id` WHERE `tasks`.id = :task_id");
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(array(
            ':task_id' => $task_id
        ));

        $data = $stmt->fetchAll();

        $students = array();

        foreach ($data as $item) {

            $students[] = new Student($item[0], $item[1], $item[2]);
        }

        return $students;
    }

     /**
     * Нахождение груп выполняющих определенное задание
     * 
     * @param int $taskId id задания
     * @return Group[] массив груп  
     */
    public function getGroupsOfTask($task_id)
    {
        //require_once "group.php";
        $stmt = $this->db->prepare("SELECT `groups`.`id` FROM `tasks` JOIN `groups` ON `groups`.`id`=`tasks`.`group_id` WHERE `tasks`.id = :task_id");
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(array(
            ':task_id' => $task_id
        ));

        $data = $stmt->fetchAll();

        $groups = array();

        foreach ($data as $item) {

            $groups[] = new Group($item[0]);
        }
        return $groups;
    }

    
    /**
     * Расчёт нагрузки проверяющих
     * Нахождение информации о проверяющих и количестве заданий которые необходимо проверить
     * 
     * @return StdClass[] массив объектов с данными о нагрузке проверяющих
     */
    public function getLoadOfInspectors()
    {
        $stmt = $this->db->prepare("SELECT `instructors`.`firstName`, `instructors`.`lastName`, COUNT(`instructors_tasks`.`task_id`) FROM `instructors`JOIN `instructors_tasks` ON `instructors_tasks`.`instructor_id` = `instructors`.`id` GROUP BY `instructors`.`id`ORDER BY COUNT(`instructors_tasks`.`task_id`) DESC;");
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute();

        $data = $stmt->fetchAll();

        $loads = array();
        foreach ($data as $item) {
            $load = new stdClass();
            $load->first_name = $item[0];
            $load->last_name = $item[1];
            $load->tasksCount =  $item[2];
            $loads[] = $load;
        }

        return $loads;
    }

    /**
     * Нахождение информации о задании, количестве студентов выполняющих задание и 
     * количестве проверяющих задание с учетом только тех заданий,
     * у которых есть проверяющие
     * 
     * @return StdClass[] массив объектов с данными о задании
     */
    public function getTaskStatistik()
    {
       
        $stmt = $this->db->query(" SELECT taskid, task, studentsCount, COUNT(instructor_id), (studentsCount / COUNT(instructor_id) )AS coefficient FROM 
        (
            SELECT DISTINCT taskid, task,  COUNT(studentid) AS studentsCount , instructors_tasks.instructor_id   FROM (
           
                   (SELECT `tasks`.id AS taskid , `tasks`.`task`, students.id AS studentid FROM `tasks`
       JOIN students ON `students`.`id` = `tasks`.`student_id`)
                   UNION
                   (SELECT `tasks`.id AS taskid, `tasks`.`task`, `groups_students`.`student_id` AS studentid FROM `tasks`
       JOIN `groups` ON `groups`.`id` = `tasks`.`group_id`
       JOIN `groups_students` ON `groups_students`.`group_id`= `groups`.`id`)
                    UNION
            (SELECT `tasks`.id AS taskid, `tasks`.`task`, `groups_students`.`student_id` AS studentid FROM `tasks`
            JOIN `lessons` ON `lessons`.`id` = `tasks`.`lesson_id`
            JOIN `groups_lessons` ON `groups_lessons`.`lesson_id` = `lessons`.`id`
            JOIN `groups_students` ON `groups_students`.`group_id` = `groups_lessons`.`group_id`)
                   ) AS T 
                    JOIN `instructors_tasks`  ON `instructors_tasks`.`task_id` = T.taskid
                    GROUP BY taskid, instructors_tasks.instructor_id
            ) AS T1 GROUP BY taskid ORDER BY coefficient DESC");
        $stmt->setFetchMode(PDO::FETCH_NUM);

        $data = $stmt->fetchAll();

        $objects = array();

        foreach ($data as $item) {
            $object = new stdClass();
            $object->task_id = $item[0];
            $object->task = $item[1];
            $object->studentsCount = $item[2];
            $object->instructorsCount = $item[3];
            $object->coefficient = $item[4];
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Нахождение студентов для определенного занятия
     * 
     * @param int $classId id занятия
     * @return Students[] массив студентов
     */
    public function getStudentsOfClass($class_id)
    {
        //require_once "student.php";
        //
        $stmt = $this->db->prepare("SELECT DISTINCT(`students`.`id`), `students`.`firstName`, `students`.`lastName` FROM students
        JOIN  `groups_students` ON `groups_students`.`student_id` = `students`.`id`
        JOIN `groups` ON `groups`.`id` = `groups_students`.`group_id`
        JOIN `groups_lessons` ON `groups_lessons`.`group_id` = `groups`.`id`
        WHERE `groups_lessons`.`lesson_id` = :class_id
        ORDER BY  `students`.`id`");

        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(array(
            ':class_id' => $class_id
        ));

        $data = $stmt->fetchAll();

        $students = array();

        foreach ($data as $item) {

            $students[] = new Student($item[0], $item[1], $item[2]);
        }

        return $students;
    }

    /**
     * Нахождение всех занятий для вывода в выпадающий список
     * 
     * @return Lesson[] массив занятий
     */
    public function getListOfLessons()
    {
       // require_once "lesson.php";
        $stmt = $this->db->query("SELECT `lessons`.id ,`lessons`.`title`, `lessons`.`description` FROM `lessons`");
        $stmt->setFetchMode(PDO::FETCH_NUM);

        $data = $stmt->fetchAll();

        $lessons = array();

        foreach ($data as $item) {

            $lessons[] = new Lesson($item[0], $item[1], $item[2]);
        }

        return $lessons;
    }

    
    /**
     * Обновление всех заданий относящихся к определенному студенту
     * в ответ на AJAX запрос
     */
    public function updateTaskOfStudent()
    {
        if (isset($_POST['student'])) {
            $students = $this->getTaskOfStudent($_POST['student']);
            echo json_encode(['status' => 'success', 'data' => $students]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Обновление количества студентов выполняющих определенное задание
     * в ответ на AJAX запрос
     */
    public function updateStudentsCount()
    {
        if (isset($_POST['task'])) {
            $studentsCount = $this->getStudentCount($_POST['task']);
            echo json_encode(['status' => 'success',  'data' => $studentsCount]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Обновление студентов для определенного занятия
     * в ответ на AJAX запрос
     */
    public function updateStudentsOfClass()
    {
        if (isset($_POST['lesson'])) {
            $students = $this->getStudentsOfClass($_POST['lesson']);
            echo json_encode(['status' => 'success', 'data' => $students]);
        } else
            echo json_encode(['status' => 'error']);
    }

    /**
     * Обновление студентов и груп выполняющих определенное задание
     * в ответ на AJAX запрос
     */
    public function updateListOfGroupsStudents()
    {
        if (isset($_POST['task'])) {
            $students = $this->getStudentsOfTask($_POST['task']);
            $groups = $this->getGroupsOfTask($_POST['task']);
            echo json_encode(['status' => 'success', 'students' => $students, 'groups' =>  $groups, 'task' => $_POST['task']]);
        } else
            echo json_encode(['status' => 'error']);
    }
}
