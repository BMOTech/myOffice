<?php
namespace App\Models;

class Note implements \JsonSerializable
{
    protected $noteID;
    protected $title;
    protected $descr;
    protected $col;
    protected $row;

    public function __construct($noteID = null, $title  = null, $descr  = null, $col  = null, $row  = null)
    {
        $this->noteID = $noteID;
        $this->title = $title;
        $this->descr = $descr;
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
        return $this->descr;
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
            'Notes' => [
                'title' => $this->getTitle()
            ]
        ];
    }}

?>