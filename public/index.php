<?php

/**
 * Einstiegspunkt des Online-Office.
 *
 * Stellt ein Login-Formular zur Verfügung. Sofern sich der Benutzer korrekt
 * authentifiziert hat, wird er in den internen Bereich geleitet.
 *
 */

use App\Service\UserService;

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP', ROOT.'app'.DIRECTORY_SEPARATOR);

require APP.'app.php';

if (isset($_SESSION['login'])) {
    UserService::redirect('intern.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // TODO: Validation und prüfen, ob User bereits vorhanden.
    //array_push($error, 'Fehler!');

    if (count($error) === 0) {
        if($userAuthService->authenticate($email, $password)) {
            UserService::redirect('intern.php');
            exit;
        } else {
            array_push($error, 'Fehler bei der Anmeldung!');
        }
    }
}

$data['title'] = 'Login';
$layout->show('login', $error, $data);
?>
