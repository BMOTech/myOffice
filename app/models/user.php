<?php
namespace App\Models;

class User
{
    protected $userID;
    protected $email;
    protected $password;
    protected $vorname;
    protected $nachname;
    protected $geschlecht;
    protected $land;
    protected $lastLogin;

    public function __construct($email = null, $password = null,
        $vorname = null, $nachname = null, $geschlecht = null, $land = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->geschlecht = $geschlecht;
        $this->land = $land;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return null
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * @return null
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * @return null
     */
    public function getGeschlecht()
    {
        return $this->geschlecht;
    }

    /**
     * @return null
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

}

?>