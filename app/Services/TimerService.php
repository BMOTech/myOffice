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

    public function stopTimer($taskID, $timerID)
    {
        $this->_database->query(
            "UPDATE Timers SET end = NOW() WHERE taskID = :taskID AND timerID = :timerID "
        );
        $this->_database->bind(':taskID', $taskID);
        $this->_database->bind(':timerID', $timerID);

        return $this->_database->execute();
    }

    public function startTimer($taskID)
    {
        $this->_database->query(
            "INSERT INTO Timers (start, taskID) VALUES (NOW(), :taskID)"
        );
        $this->_database->bind(':taskID', $taskID);

        $this->_database->execute();
        return $this->_database->lastInsertId();
    }

    public function updateTextTimer($timerID, $notiz)
    {
        $this->_database->query(
            "UPDATE Timers SET notiz = :notiz WHERE timerID = :timerID "
        );
        $this->_database->bind(':notiz', $notiz);
        $this->_database->bind(':timerID', $timerID);

        return $this->_database->execute();
    }
}