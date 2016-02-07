<?php

/**
 * Interner Bereich.
 *
 * Darf nur von authentifizierten Benutzern betrachtet werden.
 *
 */

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP', ROOT.'app'.DIRECTORY_SEPARATOR);

require APP.'app.php';

$userAuthService->isAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action'])) {

        $action = $_GET['action'];
        switch ($action) {
            case 'logout':
                $userAuthService->logout();
        }
    }
}

$data['title'] = "Interner Bereich";
$layout->show('intern', $error, $data);
?>