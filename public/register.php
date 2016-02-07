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
        $method = $_POST['method'];

        if ($method === 'emailAvailable') {
            $email = $_POST['email'];
            if ($userService->findByEmail($email) == false) {
                echo 'true';
                exit;
            } else {
                echo 'false';
                exit;
            }
        }
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $geschlecht = $_POST['geschlecht'];
        $land = $_POST['land'];

        //TODO: Validation

        $user = new User(
            $email, $password, $vorname, $nachname, $geschlecht, $land
        );

        try {
            $userService->save($user);
            if ($userAuthService->authenticate($email, $password)) {
                UserService::redirect('intern.php');
                exit;
            } else {
                array_push($error, 'Fehler bei der Anmeldung!');
            }
        } catch (Exception $e) {
            array_push($error, $e->getMessage());
        }
    }
}

$data['title'] = "Registrierung";
$layout->show('register', $error, $data);
?>

