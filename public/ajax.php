<?php

use Database\Database;
use Office\UserService\UserService;

require_once(__DIR__.'/User/Auth.php');
require_once(__DIR__.'/Database/Database.php');
require_once(__DIR__.'/User/UserService.php');

$database = new Database('localhost', 'root', 'root', 'scotchbox');
$userService = new UserService($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['method']) || !$method = $_POST['method']) {
        exit;
    }
    // TODO: auslagern wegen auth
    switch ($method) {
        case 'emailAvailable':
            $email = $_POST['email'];
            if ($userService->findByEmail($email) == false) {
                echo 'true';
            } else {
                echo 'false';
            }
        case 'authTest':
            echo 'Authed!';
    }
}
?>