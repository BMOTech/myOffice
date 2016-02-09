<?php
namespace App\Service;

use App\Models\Contact;
use App\Models\User;
use Database\Database;

class ContactService
{
    private $_database;
    private $_user;
    private $_class = "App\Models\Contact";

    public function __construct(Database $database, User $user)
    {
        $this->_database = $database;
        $this->_user = $user;
    }

    public function all()
    {
        $this->_database->query(
            "SELECT * FROM Contacts WHERE userID = :userID"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->execute();

        return $this->_database->resultset();
    }

    public function save(Contact $contact)
    {
        $this->_database->query(
            "INSERT INTO Contacts (vorname, nachname, firma, email, telefon, notizen, userID)
             VALUES (:vorname, :nachname, :firma, :email, :telefon, :notizen, :userID)"
        );
        $this->_database->bind(':vorname', $contact->getVorname());
        $this->_database->bind(':nachname', $contact->getNachname());
        $this->_database->bind(':firma', $contact->getFirma());
        $this->_database->bind(':email', $contact->getEmail());
        $this->_database->bind(':telefon', $contact->getTelefon());
        $this->_database->bind(':notizen', $contact->getNotizen());
        $this->_database->bind(':userID', $this->_user->getUserID());

        return $this->_database->execute();
    }

    public function update(Contact $contact)
    {
        $this->_database->query(
            "UPDATE Contacts SET vorname = :vorname, nachname = :nachname, firma = :firma, email = :email, telefon = :telefon, notizen = :notizen WHERE contactID = :contactID"
        );
        $this->_database->bind(':vorname', $contact->getVorname());
        $this->_database->bind(':nachname', $contact->getNachname());
        $this->_database->bind(':firma', $contact->getFirma());
        $this->_database->bind(':email', $contact->getEmail());
        $this->_database->bind(':telefon', $contact->getTelefon());
        $this->_database->bind(':notizen', $contact->getNotizen());
        $this->_database->bind(':contactID', $contact->getId());

        return $this->_database->execute();
    }

    public function delete($contactID)
    {
        $this->_database->query(
            "DELETE FROM Contacts WHERE contactID = :contactID AND userID = :userID"
        );
        $this->_database->bind(':contactID', $contactID);
        $this->_database->bind(':userID', $this->_user->getUserID());

        return $this->_database->execute();
    }

    public function getContactByID($contactID)
    {
        $this->_database->query(
            "SELECT * FROM Contacts WHERE userID = :userID AND contactID = :contactID"
        );
        $this->_database->bind(':userID', $this->_user->getUserID());
        $this->_database->bind(':contactID', $contactID);
        $this->_database->execute();

        return $this->_database->single();
    }
}