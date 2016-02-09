<?php

/**
 * Registrierung.
 *
 * Stellt ein Registrierungsformular zur Verfügung.
 *
 */

use App\Models\User;
use App\Service\UserService;

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP', ROOT.'app'.DIRECTORY_SEPARATOR);

require APP.'app.php';

if (isset($_SESSION['login'])) {
    UserService::redirect('intern.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['method'])) {
        $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

        if ($method === 'emailAvailable') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if ($userService->findByEmail($email) == false) {
                echo 'true';
                exit;
            } else {
                echo 'false';
                exit;
            }
        }
    } else {
        $regData = array();

        $validUser = $validator->validateRegistration($regData);

        if ($validUser) {
            $user = new User(
                $regData['email'], $regData['password'], $regData['vorname'],
                $regData['nachname'], $regData['geschlecht'], $regData['land']
            );

            try {
                $userService->save($user);
                if ($userAuthService->authenticate(
                    $regData['email'], $regData['password']
                )
                ) {
                    UserService::redirect('intern.php');
                    exit;
                } else {
                    $validator->setErrors('Fehler bei der Anmeldung');
                }
            } catch (Exception $e) {
                $validator->setErrors($e->getMessage());
            }
        }
    }
}

$data['title'] = "Registrierung";
$layout->show('register', $validator->getErrors(), $data);
?>

