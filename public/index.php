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
    UserService::redirect('/intern.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginData = array();

    $validUser = $validator->validateLogin($loginData);

    if ($validUser) {
        if ($userAuthService->authenticate($loginData['email'], $loginData['password'])) {
            UserService::redirect('intern.php');
            exit;
        } else {
            $validator->setErrors('Fehler bei der Anmeldung!');
        }
    }
}

$data['title'] = 'Login';
$layout->show('login', $validator->getErrors(), $data);
