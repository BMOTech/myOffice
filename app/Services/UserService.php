<?php
namespace App\Service;

use App\Models\User;
use Database\Database;
use Exception;

class UserService
{
    private $_database;
    private $_class = "App\Models\User";

    public function __construct(Database $database)
    {
        $this->_database = $database;
    }

    public function save(User $user)
    {
        if (!$this->findByEmail($user->getEmail())) {
            $this->_database->query(
                "INSERT INTO Users (email, password, vorname, nachname, land, geschlecht)
                    VALUES (:email, :password, :vorname, :nachname, :land, :geschlecht)"
            );
            $this->_database->bind(':email', $user->getEmail());
            $this->_database->bind(':password', $user->getPassword());
            $this->_database->bind(':vorname', $user->getVorname());
            $this->_database->bind(':nachname', $user->getNachname());
            $this->_database->bind(':land', $user->getLand());
            $this->_database->bind(':geschlecht', $user->getGeschlecht());
            $this->_database->execute();

            return $this->findByEmail($user->getEmail());
        } else {
            throw new Exception("Dieser Benutzer existiert bereits!");
        }
    }

    public function saveLastLogin(User $user)
    {
        if ($this->findByID($user->getUserID())) {
            $this->_database->query(
                "UPDATE Users
                    SET lastLogin = NOW()
                    WHERE userID = :userID"
            );
            $this->_database->bind(':userID', $user->getUserID());

            return $this->_database->execute();
        } else {
            throw new Exception("Konnte keinen Benutzer finden!");
        }
    }

    public function getUserByCredentials($email, $password)
    {
        $this->_database->query(
            "SELECT *
                FROM Users
                WHERE email = :email AND password = :password"
        );
        $this->_database->bind(':email', $email);
        $this->_database->bind(':password', $password);
        $this->_database->execute();

        return $this->_database->single($this->_class);
    }

    public function findByEmail($email)
    {
        $this->_database->query(
            "SELECT * FROM Users WHERE email = :email"
        );
        $this->_database->bind(':email', $email);
        $this->_database->execute();

        return $this->_database->single($this->_class);
    }

    public function findByID($uid)
    {
        $this->_database->query(
            "SELECT * FROM Users WHERE userID = :uid"
        );
        $this->_database->bind(':uid', $uid);
        $this->_database->execute();

        return $this->_database->single($this->_class);
    }

    public function all()
    {
        $this->_database->query(
            "SELECT * FROM Users"
        );
        $this->_database->execute();

        return $this->_database->resultset($this->_class);
    }

    public static function redirect($url)
    {
        header("Location: $url");
    }

    public function getLastLogin() {
        return [
            'lastLogin' => [
                'date' => $_SESSION['lastLogin']
                ]
            ];
    }

}

?>