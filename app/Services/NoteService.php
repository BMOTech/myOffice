<?php
namespace App\Service;

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
}