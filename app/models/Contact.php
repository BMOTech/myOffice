<?php
namespace App\Models;

class Contact
{
    protected $id;
    protected $vorname;
    protected $nachname;
    protected $firma;
    protected $email;
    protected $telefon;
    protected $notizen;

    public function __construct($contactID, $vorname, $nachname, $firma, $email,
        $telefon, $notizen
    ) {
        $this->id = $contactID;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->firma = $firma;
        $this->email = $email;
        $this->telefon = $telefon;
        $this->notizen = $notizen;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
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
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * @return null
     */
    public function getNotizen()
    {
        return $this->notizen;
    }
}