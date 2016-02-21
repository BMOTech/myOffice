<?php
namespace App\Service;

use App\Models\Note;
use App\Models\User;
use Database\Database;

class NoteService
{
    private $_database;
    private $_user;
    private $_class = "App\Models\Note";

    public function __construct(Database $database, User $user)
    {
        $this->_database = $database;
        $this->_user = $user;
    }

    public function all()
    {
        $this->_database->query(
            "SELECT * FROM Notes WHERE userID = :userID"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->execute();

        return $this->_database->resultset();
    }

    public function savePos($id, $column, $row)
    {
        $this->_database->query(
            "UPDATE Notes SET row = :row, col = :column WHERE noteID = :noteID"
        );
        $this->_database->bind(':row', $row);
        $this->_database->bind(':column', $column);
        $this->_database->bind(':noteID', $id);
        return $this->_database->execute();
    }

    public function save($title)
    {
        $freeRow = $this->getFirstFreeRow();

        $this->_database->query(
            "INSERT INTO Notes (title, userID, col, row) VALUES (:title, :userID, 1, :freerow)"
        );
        $this->_database->bind(':title', $title);
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->bind(':freerow', $freeRow);

        return $this->_database->execute();
    }

    private function getFirstFreeRow() {
        $this->_database->query(
            "SELECT MAX(row) FROM Notes WHERE userID = :userID AND col = 1"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->execute();

        $value = $this->_database->single();
        $max = intval($value['MAX(row)']) + 1;
        return $max;
    }

    public function update($id, $heading, $text)
    {
        $this->_database->query(
            "UPDATE Notes SET title = :title, descr = :text WHERE noteID = :noteID"
        );
        $this->_database->bind(':title', $heading);
        $this->_database->bind(':text', $text);
        $this->_database->bind(':noteID', $id);
        return $this->_database->execute();
    }

    public function delete($id)
    {
        $this->_database->query(
            "DELETE FROM Notes WHERE noteID = :noteID AND userID = :userID"
        );
        $this->_database->bind(':noteID', $id);
        $this->_database->bind(':userID', $this->_user->getUserID());

        return $this->_database->execute();
    }

}