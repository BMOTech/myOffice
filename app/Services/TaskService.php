<?php
namespace App\Service;

use App\Models\Task;
use App\Models\User;
use Database\Database;

class TaskService
{
    private $_database;
    private $_user;
    private $_class = "App\Models\Task";

    public function __construct(Database $database, User $user)
    {
        $this->_database = $database;
        $this->_user = $user;
    }

    public function all()
    {
        $this->_database->query(
            "SELECT ta.taskID, ta.description, ta.userID, ti.timerID, ti.start, ti.end, ti.notiz FROM (SELECT * FROM Tasks WHERE userID = :userID) as ta LEFT JOIN Timers ti ON ta.taskID = ti.taskID;"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->execute();

        $tasks = $this->_database->resultset();

        $output = array();
        $currentTaskID = "";

        foreach ($tasks as $task) {
            if ($task['taskID'] !== $currentTaskID) {
                $output[] = array();

                // get a reference to the newly added array element
                end($output);
                $currentItem = &$output[key($output)];

                $currentTaskID = $task['taskID'];
                $currentItem['taskID'] = $currentTaskID;
                $currentItem['description'] = $task['description'];
                $currentItem['timers'] = array();
            }
            $currentItem['timers'][] = array("start" => $task['start'],
                                             "end"   => $task['end'],
                                             "notiz" => $task['notiz'],
                                             "timerID" => $task['timerID']);
        }

        return json_encode($output);
    }

    public function save(Task $task)
    {
        $this->_database->query(
            "INSERT INTO Tasks (description, userID) VALUES (:description, :userID)"
        );
        $this->_database->bind(':description', $task->getDescription());
        $this->_database->bind(':userID', $this->_user->getUserID());

        return $this->_database->execute();
    }

    public function delete($taskID)
    {
        $this->_database->query(
            "DELETE FROM Tasks WHERE taskID = :taskID AND userID = :userID"
        );
        $this->_database->bind(':taskID', $taskID);
        $this->_database->bind(':userID', $this->_user->getUserID());

        return $this->_database->execute();
    }

    public function update(Task $task) {
        $this->_database->query(
            "UPDATE Tasks SET description = :description WHERE taskID = :taskID"
        );
        $this->_database->bind(':description', $task->getDescription());
        $this->_database->bind(':taskID', $task->getTaskID());
        return $this->_database->execute();
    }
}