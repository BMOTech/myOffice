<?php
use App\Service\UserAuthService;
use App\Service\UserService;
use Database\Database;
use App\Layout\Layout;
use Validator\Validator;

require APP . 'config/config.php';
require APP . 'database/database.php';
require APP . 'layout/layout.php';
require APP . 'models/User.php';
require APP . 'models/Event.php';
require APP . 'models/Contact.php';
require APP . 'models/Task.php';
require APP . 'models/Timer.php';
require APP . 'services/UserService.php';
require APP . 'services/UserAuthService.php';
require APP . 'validator/Validator.php';

$database = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userService = new UserService($database);
$userAuthService = new UserAuthService($userService);
$validator = new Validator();
$layout = new Layout();

session_start();
?>