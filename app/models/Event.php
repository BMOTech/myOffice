<?php
namespace App\Models;

class Event
{
    protected $id;
    protected $title;
    protected $start;
    protected $text;

    public function __construct($id, $title, $start, $text)
    {
        $this->id = $id;
        $this->title = $title;
        $this->start = new \DateTime($start);
        $this->text = $text;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}