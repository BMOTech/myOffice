<?php
namespace App\Models;

class Timer
{
    protected $timerID;
    protected $start;
    protected $end;

    public function __construct($timerID, $start, $end)
    {
        $this->timerID = $timerID;
        $this->start = $start;
        $this->end = $end;
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
    public function getEnd()
    {
        return $this->end;
    }
}

?>