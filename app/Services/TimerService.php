<?php
namespace App\Service;

use App\Models\Task;
use App\Models\Timer;
use App\Models\User;
use Database\Database;

class TimerService
{
    private $_database;
    private $_user;
    private $_class = "App\Models\Timer";

    public function __construct(Database $database, User $user)
    {
        $this->_database = $database;
        $this->_user = $user;
    }

    public function all($taskID)
    {
        $this->_database->query(
            "SELECT * FROM Timers WHERE taskID = :taskID"
        );
        $this->_database->bind(':taskID', $taskID);
        $this->_database->execute();

        return $this->_database->resultset();
    }

    public function save(Timer $timer, Task $task)
    {
        $this->_database->query(
            "INSERT INTO Timers (start, end, taskID) VALUES (:start, :end, :taskID)"
        );
        $this->_database->bind(':start', $timer->getStart());
        $this->_database->bind(':end', $timer->getEnd());
        $this->_database->bind(':taskID', $task->getTaskID());
        return $this->_database->execute();
    }
}