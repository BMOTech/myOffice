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

        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        switch ($action) {
            case 'logout':
                $userAuthService->logout();
        }
    }
}

$data['title'] = "Interner Bereich";
$layout->show('intern', $validator->getErrors(), $data);