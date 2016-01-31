<?php
use Database\Database;
use Office\User\User;
use Office\UserService\UserService;

session_start();

require_once(__DIR__.'/Database/Database.php');
require_once(__DIR__.'/User/User.php');
require_once(__DIR__.'/User/UserService.php');

$message = array();
$database = new Database('localhost', 'root', 'root', 'scotchbox');
$userService = new UserService($database);

if (isset($_SESSION['login'])) {
    UserService::redirect('intern.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!User::login($userService)) {
        $message['error'] = "Es ist ein Fehler beim Login aufgetreten, bitte versuchen Sie es erneut!";
    }
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myOffice - Login</title>

    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <?php if (isset($message['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <?php echo $message['error']; ?>
            </div>
        <?php endif; ?>
        <form id="loginForm" action="index.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <input type="text" name="email" placeholder="Email"
                       required="true" autofocus="true"
                       class="form-control"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Passwort"
                       required="true" class="form-control"/>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">
                Anmelden
            </button>
            <hr/>
            <p>Benötigen Sie einen Account? <a
                    href="/register.php">Registrieren</a></p>
        </form>
    </div>



</div>
<!--  <script src="js/libraries.js"></script>  -->
<script src="js/main.js"></script>
</body>
</html>