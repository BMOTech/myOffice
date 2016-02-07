<?php
namespace App\Service;

use App\Models\Event;
use App\Models\User;
use Database\Database;
use Exception;

class EventService
{
    private $_database;
    private $_user;
    private $_eventClass = "App\Models\Event";

    public function __construct(Database $database, User $user)
    {
        $this->_database = $database;
        $this->_user = $user;
    }

    public function all()
    {
        $this->_database->query(
            "SELECT * FROM Events WHERE userID = :userID"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->execute();

        return $this->_database->resultset();
    }

    public function save(Event $event)
    {
        $this->_database->query(
            "INSERT INTO Events (title, start, userID) VALUES (:title, :start, :userID)"
        );
        $this->_database->bind(':title', $event->getTitle());
        $this->_database->bind(':start', $event->getStart()->format('Y-m-d H:i:s'));
        $this->_database->bind(':userID', $this->_user->getUserID());
        return $this->_database->execute();
    }
}