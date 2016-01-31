<?php
namespace Office\UserService;

use Database\Database;
use Exception;
use Office\User\User;

class UserService
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param $email
     *
     * @return Einen Benutzer, bzw. false falls kein Benutzer gefunden wurde.
     */
    public function findByEmail($email)
    {
        $this->database->query(
            "SELECT * FROM Users WHERE email = :email"
        );
        $this->database->bind(':email', $email);
        $this->database->execute();

        return $this->database->single();
    }

    public function save(User $user)
    {
        if (!$this->findByEmail($user->getEmail())) {
            $this->database->query(
                "INSERT INTO Users (email, password) VALUES (:email, :password)"
            );
            $this->database->bind(':email', $user->getEmail());
            $this->database->bind(':password', $user->getPassword());
            $this->database->execute();

            return $this->database->lastInsertId();
        } else {
            throw new Exception("Dieser Benutzer existiert bereits!");
        }
    }

    public function login(User $user)
    {
        $this->database->query(
            "SELECT * FROM Users WHERE email = :email AND password = :password"
        );
        $this->database->bind(':email', $user->getEmail());
        $this->database->bind(':password', $user->getPassword());
        $this->database->execute();

        if ($this->database->rowCount() === 1) {
            $_SESSION = array(
                'login' => true,
                'user'  => $this->findByEmail($user->getEmail())
            );
            setcookie('email', $user->getEmail(), strtotime("+1 month"));
            $_COOKIE['email'] = $user->getEmail();
            $this->redirect('intern.php');
            return true;
        };
        return false;
    }

    public function all()
    {
        $this->database->query(
            "SELECT * FROM Users"
        );
        $this->database->execute();

        return $this->database->resultset("Office\User\User");
    }

    public static function redirect($url)
    {
        header("Location: $url");
    }

}

?>