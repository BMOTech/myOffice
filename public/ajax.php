<?php

/**
 * Zentrale Anlaufstelle für alle internen Ajax Calls.
 *
 * Das Skript darf nur von eingeloggten Benutzern aufgerufen werden, deshalb
 * wird zunächst geprüft, ob der Benutzer überhaupt authentifiziert ist.
 *
 */

use App\Models\Event;
use App\Service\EventService;

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

require APP . 'app.php';
require APP.'Services/EventService.php';

$userAuthService->isAuthenticated();

$user = $userService->findByEmail($_SESSION['user']);
$eventService = new EventService($database, $user);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['method']) || !$method = $_POST['method']) {
        exit;
    }
    switch ($method) {
        case 'cal_fetch':
            echo json_encode($eventService->all());
            break;
        case 'cal_save':
            $title = $_POST['title'];
            $date = new DateTime($_POST['date']);
            $text = $_POST['text'];

            $event = new Event(null, $title, $date, $text);
            echo json_encode($eventService->save($event));

            break;
        case 'cal_update':
            $id = $_POST['id'];
            $title = $_POST['title'];
            $date = new DateTime($_POST['date']);
            $text = $_POST['text'];

            $event = new Event($id, $title, $date, $text);
            echo json_encode($eventService->update($event));

            break;
        default:
            http_response_code(404);
            break;
    }
}
?>