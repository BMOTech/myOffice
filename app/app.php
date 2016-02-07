<?php
use App\Service\UserAuthService;
use App\Service\UserService;
use Database\Database;
use App\Layout\Layout;

require APP . 'config/config.php';
require APP . 'database/database.php';
require APP . 'layout/layout.php';
require APP . 'Models/User.php';
require APP . 'Models/Event.php';
require APP . 'Services/UserService.php';
require APP . 'Services/UserAuthService.php';

$error = array();
$database = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userService = new UserService($database);
$userAuthService = new UserAuthService($userService);
$layout = new Layout();

session_start();
?>