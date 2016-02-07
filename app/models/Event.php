<?php
namespace App\Models;

class Event
{
    protected $eventID;
    protected $title;
    protected $start;
    protected $end;
    protected $allday;

    public function __construct($title = null, $start = null, $end = null, $allday = null)
    {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->allday = $allday;
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

}