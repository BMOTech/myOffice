<?php
namespace App\Service;

use App\Models\User;

class UserAuthService
{

    private $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    public function isAuthenticated()
    {
        if (!isset($_SESSION['login'])) {
            header('HTTP/1.1 401 Unauthorized');
            die('Authorization Required');
        }
    }

    public function authenticate($email, $password)
    {
        $user = $this->_userService->getUserByCredentials($email, $password);
        if ($user !== false) {
            $_SESSION = array(
                'login' => true,
                'user'  => $user->getEmail(),
                'lastLogin' => $user->getLastLogin(),
            );
            setcookie('email', $user->getEmail(), strtotime("+1 month"));
            setcookie('lastLogin', $user->getLastLogin(), strtotime("+1 month"));
            $_COOKIE['email'] = $user->getEmail();
            $this->_userService->saveLastLogin($user);

            return true;
        }

        return false;
    }

    /**
     * Beim Logout wird die Session zerstört und das gesetzte Cookie gelöscht.
     *
     * Anschließend wird der Benutzer zur Startseite geleitet.
     */
    public function logout()
    {
        session_destroy();
        $_SESSION = array();
        setcookie("email", "", time() - 10, "/");
        UserService::redirect('index.php');
    }
}

?>