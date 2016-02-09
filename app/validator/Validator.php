<?php
namespace Validator;

use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;

class Validator
{
    private $_errors = array();
    private $_data = array();

    public function validateRegistration(&$arr)
    {
        $this->checkEmail();
        $this->checkString("password");
        $this->checkString("password2");
        $this->checkString("vorname");
        $this->checkString("nachname");
        $this->checkString("geschlecht");
        $this->checkString("land");

        if ($this->_data['password'] !== $this->_data['password2']) {
            $this->_errors['samePassword']
                = 'Bitte geben Sie zwei identische Kennwörter ein!';
        }

        return $this->checkForErrors($arr);
    }

    public function saveContact(&$arr)
    {
        $this->checkString("vorname");
        $this->checkString("nachname");
        $this->checkString("firma");
        $this->checkEmail();
        $this->checkString("telefon");
        $this->checkString("notizen");

        return $this->checkForErrors($arr);
    }

    public function updateContact(&$arr)
    {
        $this->checkInt("id");
        $this->checkString("vorname");
        $this->checkString("nachname");
        $this->checkString("firma");
        $this->checkEmail();
        $this->checkString("telefon");
        $this->checkString("notizen");

        return $this->checkForErrors($arr);
    }

    public function validateLogin(&$arr)
    {
        $this->checkEmail();
        $this->checkString("password");

        return $this->checkForErrors($arr);
    }

    public function saveEvent(&$arr)
    {
        $this->checkString("title");
        $this->checkString("text");
        $this->checkDate("date");

        return $this->checkForErrors($arr);
    }

    public function updateEvent(&$arr)
    {
        $this->checkInt("id");
        $this->checkString("title");
        $this->checkString("text");
        $this->checkDate("date");

        return $this->checkForErrors($arr);
    }

    private function checkEmail()
    {
        if (!($this->_data['email'] = filter_input(
            INPUT_POST, 'email', FILTER_VALIDATE_EMAIL
        ))
        ) {
            $this->_errors['email']
                = 'Bitte geben Sie eine gültige Email-Adresse ein!';
        }
    }

    private function checkString($string)
    {
        if (!($this->_data[$string] = filter_input(
            INPUT_POST, $string, FILTER_SANITIZE_STRING
        ))
        ) {
            $this->_errors[$string]
                = ucfirst($string).' ungültig!';
        }
        if (($this->_data[$string] != filter_input(INPUT_POST, $string))) {
            $this->_errors[$string]
                = ucfirst($string).' ungültig!';
        }
    }

    private function checkForErrors(&$arr)
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

    public function getErrors()
    {
        return $this->_errors;
    }

    public function setErrors($errMsg)
    {
        $this->_errors['Allgemeiner Fehler']
            = $errMsg;
    }

    private function checkDate($field)
    {
        $date = filter_input(INPUT_POST, $field);
        try {
            new DateTime($date);
            $this->_data[$field] = $date;
        } catch (Exception $e) {
            $this->_errors[$field] = $e->getMessage();
        }
    }

    private function checkInt($string)
    {
        if (!($this->_data[$string] = filter_input(
            INPUT_POST, $string, FILTER_VALIDATE_INT
        ))
        ) {
            $this->_errors[$string]
                = 'Keine gültige Zahl übergeben!';
        }
    }

    public function validID(&$arr)
    {
        $this->checkInt("id");

        return $this->checkForErrors($arr);
    }
}