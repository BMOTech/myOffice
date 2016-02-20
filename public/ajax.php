<?php

/**
 * Zentrale Anlaufstelle für alle internen Ajax Calls.
 *
 * Das Skript darf nur von eingeloggten Benutzern aufgerufen werden, deshalb
 * wird zunächst geprüft, ob der Benutzer überhaupt authentifiziert ist.
 *
 */

use App\Models\Contact;
use App\Models\Event;
use App\Models\Task;
use App\Service\ContactService;
use App\Service\EventService;
use App\Service\NoteService;
use App\Service\TaskService;
use App\Service\TimerService;

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP', ROOT.'app'.DIRECTORY_SEPARATOR);

require APP.'app.php';
require APP.'Services/EventService.php';
require APP.'Services/ContactService.php';
require APP.'Services/TaskService.php';
require APP.'Services/TimerService.php';
require APP.'Services/NoteService.php';

$userAuthService->isAuthenticated();

$user = $userService->findByEmail($_SESSION['user']);
$eventService = new EventService($database, $user);
$contactService = new ContactService($database, $user);
$taskService = new TaskService($database, $user);
$timerService = new TimerService($database, $user);
$noteService = new NoteService($database, $user);

header('Content-Type: application/json');

/**
 * @param $data
 */
function showError($data)
{
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(
        array('message' => 'error', 'errors' => json_encode($data))
    ));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['method']) || !$method = $_POST['method']) {
        exit;
    }
    switch ($method) {
        case 'cal_fetch':
            echo json_encode($eventService->all());
            break;
        case 'cal_save':
            $data = array();
            $validID = $validator->saveEvent($data);
            if ($validID) {
                $event = new Event(
                    null, $data['title'], $data['date'], $data['text']
                );
                if ($eventService->save($event)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim speichern.");
                }
            } else {
                showError($data);
            }
            break;
        case 'cal_update':
            $data = array();
            $validID = $validator->updateEvent($data);
            if ($validID) {
                $event = new Event(
                    $data['id'], $data['title'], $data['date'], $data['text']
                );
                if ($eventService->update($event)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim speichern.");
                }
            } else {
                showError($data);
            }
            break;
        case 'cal_delete':
            $data = array();
            $validID = $validator->validID($data);
            if ($validID) {
                $id = $data['id'];
                if ($eventService->delete($id)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim löschen.");
                }
            } else {
                showError($data);
            }
            break;
        case 'contact_fetch':
            echo json_encode($contactService->all());
            break;
        case 'contact_fetch_id':
            $data = array();
            $validID = $validator->validID($data);
            if ($validID) {
                $id = $data['id'];
                echo json_encode($contactService->getContactByID($id));
            } else {
                showError($data);
            }
            break;
        case 'contact_save':
            $data = array();
            $validID = $validator->saveContact($data);
            if ($validID) {
                $contact = new Contact(
                    null, $data['vorname'], $data['nachname'], $data['firma'],
                    $data['email'], $data['telefon'], $data['notizen']
                );
                if ($contactService->save($contact)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim speichern.");
                }
            } else {
                showError($data);
            }
            break;
        case 'contact_update':
            $data = array();
            $validID = $validator->updateContact($data);
            if ($validID) {
                $contact = new Contact(
                    $data['id'], $data['vorname'], $data['nachname'],
                    $data['firma'], $data['email'], $data['telefon'],
                    $data['notizen']
                );
                if ($contactService->update($contact)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim aktualisieren.");
                }
            } else {
                showError($data);
            }
            break;
        case 'contact_delete':
            $data = array();
            $validID = $validator->validID($data);
            if ($validID) {
                $id = $data['id'];
                if ($contactService->delete($id)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim löschen.");
                }
            } else {
                showError($data);
            }
            break;
        case 'task_fetch':
            echo json_encode($taskService->all());
            break;
        case 'task_save':
            $data = array();
            $validID = $validator->saveTask($data);
            if ($validID) {
                $task = new Task(
                    null, $data['description']
                );
                if ($taskService->save($task)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim speichern.");
                }
            } else {
                showError($data);
            }
            break;
        case 'task_update':
            $data = array();
            $validID = $validator->updateTask($data);
            if ($validID) {
                $task = new Task($data['id'], $data['name']);
                if ($taskService->update($task)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim aktualisieren.");
                }
            } else {
                showError($data);
            }
            break;
        case 'task_delete':
            $data = array();
            $validID = $validator->validID($data);
            if ($validID) {
                $id = $data['id'];
                if ($taskService->delete($id)) {
                    echo json_encode(array("message" => "success"));
                } else {
                    showError("Unbekannter Fehler beim löschen.");
                }
            } else {
                showError($data);
            }
            break;
        case 'timer_start':
            $data = array();
            $validID = $validator->validID($data);
            if ($validID) {
                $id = $data['id'];
                echo json_encode(array("timerID" => $timerService->startTimer($id)));
            } else {
                showError($data);
            }
            break;
        case 'timer_stop':
            $data = array();
            $validID = $validator->stopTimer($data);
            if ($validID) {
                echo json_encode($timerService->stopTimer($data['taskID'], $data['timerID']));
            } else {
                showError($data);
            }
            break;
        case 'stopwatch_update_text':
            $data = array();
            $validID = $validator->updateTextTimer($data);
            if ($validID) {
                echo json_encode($timerService->updateTextTimer($data['id'], $data['notiz']));
            } else {
                showError($data);
            }
            break;
        case 'notes_fetch':
            echo json_encode($noteService->all());
            break;
        default:
            http_response_code(404);
            break;
    }
}
?>