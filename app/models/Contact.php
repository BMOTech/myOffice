<?php
namespace App\Models;

class Contact implements \JsonSerializable
{
    protected $id;
    protected $vorname;
    protected $nachname;
    protected $firma;
    protected $email;
    protected $telefon;
    protected $notizen;

    public function __construct($contactID = null, $vorname = null, $nachname = null, $firma = null, $email = null,
        $telefon = null, $notizen = null
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'Contacts' => [
                'vorname' => $this->getVorname(),
                'nachname' => $this->getNachname()
            ]
        ];
    }}