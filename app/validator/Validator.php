<?php
namespace Validator;

use App\Models\Event;
use App\Models\User;
use DateTime;
use Exception;
use Service;

interface Validator
{
    function save(&$data);
}

abstract class newValidator
{
    protected $_errors = array();
    protected $_data = array();

    public function validateID()
    {
        if (!($this->_data['id'] = filter_input(
            INPUT_POST, 'id', FILTER_VALIDATE_INT
        ))
        ) {
            $this->_errors['id']
                = 'Keine gültige Zahl übergeben!';
        }
    }

    protected function checkForErrors(&$arr)
    {
        if (!empty($this->_errors)) {
            $arr = $this->_errors;

            return false;
        }

        foreach ($this->_data as $k => $v) {
            $arr[$k] = $v;
        }

        return true;
    }

    protected function checkString($string)
    {
        if (!($this->_data[$string] = filter_input(
            INPUT_POST, $string, FILTER_SANITIZE_STRING
        ))
        ) {
            $this->_errors[$string]
                = ucfirst($string) . ' ungültig!';
        }
        if ((($this->_data[$string] != filter_input(INPUT_POST, $string)))) {
            $this->_errors[$string]
                = ucfirst($string) . ' ungültig!';
        }
    }

    protected function checkDate($field)
    {
        $date = filter_input(INPUT_POST, $field);
        try {
            new DateTime($date);
            $this->_data[$field] = $date;
        } catch (Exception $e) {
            $this->_errors[$field] = $e->getMessage();
        }
    }

    protected function checkEmail()
    {
        if (!($this->_data['email'] = filter_input(
            INPUT_POST, 'email', FILTER_VALIDATE_EMAIL
        ))
        ) {
            $this->_errors['email']
                = 'Bitte geben Sie eine gültige Email-Adresse ein!';
        }
    }

}

class CalendarValidator extends newValidator implements Validator
{

    public function save(&$data)
    {
        $this->checkString("title");
        $this->checkString("text");
        $this->checkDate("date");

        if ($this->checkForErrors($data)) {
            return new Event(null, $this->_data['title'], $this->_data['start'], $this->_data['text']);
        } else {
            return false;
        }
    }
}


class LoginValidator extends newValidator implements Validator
{

    public function save(&$data)
    {
        $this->checkEmail();
        $this->checkString("password");

        if ($this->checkForErrors($data)) {
            return new User(null, $this->_data['id'], $this->_data['password']);
        } else {
            return false;
        }
    }
}
class AjaxService
{

    private $service;
    private $validator;

    function __construct(Validator $validator, Service $service)
    {
        $this->validator = $validator;
        $this->service = $service;
    }

    public function saveMe()
    {
        $data = array();
        $model = $this->validator->save($data);
        if ($model !== false) {
            if ($this->service->save($model)) {
                echo json_encode(array("message" => "success"));
            } else {
                $this->showError("Unbekannter Fehler beim speichern.");
            }
        } else {
            $this->showError($data);
        }
    }

    private function showError($data)
    {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(
            array('message' => 'error', 'errors' => json_encode($data))
        ));
    }
}