<?php
namespace App\Models;

class Note
{
    protected $noteID;
    protected $title;
    protected $desc;
    protected $col;
    protected $row;

    public function __construct($noteID, $title, $desc, $col, $row)
    {
        $this->noteID = $noteID;
        $this->title = $title;
        $this->desc = $desc;
        $this->col = $col;
        $this->row = $row;
    }

    /**
     * @return mixed
     */
    public function getNoteID()
    {
        return $this->noteID;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return mixed
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * @return mixed
     */
    public function getRow()
    {
        return $this->row;
    }

}

?>