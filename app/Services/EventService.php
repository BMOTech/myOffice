<?php
namespace App\Service;

use App\Models\Event;
use App\Models\User;
use Database\Database;

class EventService
{
    private $_database;
    private $_user;
    private $_class = "App\Models\Event";

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
            "INSERT INTO Events (title, start, text, userID) VALUES (:title, :start, :text, :userID)"
        );
        $this->_database->bind(':title', $event->getTitle());
        $this->_database->bind(':start', $event->getStart()->format('Y-m-d H:i:s'));
        $this->_database->bind(':text', $event->getText());
        $this->_database->bind(':userID', $this->_user->getUserID());
        return $this->_database->execute();
    }

    public function update(Event $event)
    {
        $this->_database->query(
            "UPDATE Events SET title = :title, text = :text WHERE id = :eventID"
        );
        $this->_database->bind(':title', $event->getTitle());
        $this->_database->bind(':eventID', $event->getId());
        $this->_database->bind(':text', $event->getText());
        return $this->_database->execute();
    }

    public function delete($eventID)
    {
        $this->_database->query(
            "DELETE FROM Events WHERE id = :eventID AND userID = :userID"
        );
        $this->_database->bind(':eventID', $eventID);
        $this->_database->bind(':userID', $this->_user->getUserID());
        return $this->_database->execute();
    }

    public function last($limit)
    {
        $this->_database->query(
            "SELECT *
                FROM (
                       SELECT *
                       FROM Events
                       WHERE userID = :userID AND start >= DATE(NOW())
                       ORDER BY start ASC
                       LIMIT :limit
                     ) events
                ORDER BY start ASC"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->bind(':limit', $limit);
        $this->_database->execute();

        return $this->_database->resultset($this->_class);
    }
}