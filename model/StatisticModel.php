<?php

namespace models;

use models\entities\Load;

class StatisticModel
{

    private array $tasks;
    private array $instructors;

    public function __construct($instructors)
    {
        $this->instructors = $instructors;
    }

     /**
     * Нахождение информации о задании, количестве студентов выполняющих задание и 
     * количестве проверяющих задание с учетом только тех заданий,
     * у которых есть проверяющие
     * 
     * @return Load[] массив объектов с данными о задании
     */
    public function getCriticalLoadedStatistic($tasks,$studentCounts)
    {
        $loads = array();
        $this->tasks = $tasks;
        
        foreach ($this->tasks as $task) {

           
            $studentsCount = $studentCounts[$task->getId()];
        
            $instructorsCount = 0;

            foreach ($this->instructors as $instructor) {

                foreach ($instructor->getTasks() as $instructorTask) {

                    if ($instructorTask->getId() == $task->getId())
                        $instructorsCount++;
                }
            }
            //
            $loads[] = new Load($task->getId(), $studentsCount->getCount(), $instructorsCount);
        }

        return $loads;
    }

    /**
     * Расчёт нагрузки проверяющих
     * Нахождение информации о проверяющих и количестве заданий которые необходимо проверить
     * 
     * @return Instructor[] массив объектов с данными о нагрузке проверяющих
     */
    public function getTaskLoadsStatistic()
    {
        foreach ($this->instructors as $instructor) {
            $count = count($instructor->getTasks());
            $instructor->setTasksCount($count);
        }

        usort($this->instructors, function ($instructor, $nextInstructor) {
            return $instructor->getTasksCount() < $nextInstructor->getTasksCount();
        });

        return $this->instructors;
    }
}
