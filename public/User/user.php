<?php
namespace Office\User;

use Office\UserService\UserService;

class User
{
    protected $userID;
    protected $email;
    protected $password;

    public function __construct($email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function register(UserService $userService)
    {
        $formvars = array();

        $formvars['email'] = $_POST['email'];
        $formvars['password'] = $_POST['password'];

        $user = new User($formvars['email'], $formvars['password']);

        $userService->save($user);

        return $userService->showInfo(
            'Der Benutzer wurde hinzugefügt. Sie können sich nun anmelden.'
        );
    }

    public static function login(UserService $userService)
    {
        $formvars = array();

        $formvars['email'] = $_POST['email'];
        $formvars['password'] = $_POST['password'];

        $user = new User($formvars['email'], $formvars['password']);

        $userService->login($user);
    }

    public static function logout()
    {
        session_destroy();
        $_SESSION = array();
        UserService::redirect('index.php');

        return true;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}

?>