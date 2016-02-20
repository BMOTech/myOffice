<?php
namespace App\Models;

class Timer
{
    protected $timerID;
    protected $start;
    protected $end;
    protected $notiz;

    public function __construct($timerID, $start, $end, $notiz = null)
    {
        $this->timerID = $timerID;
        $this->start = $start;
        $this->end = $end;
        $this->notiz = $notiz;
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

    /**
     * @return null
     */
    public function getNotiz()
    {
        return $this->notiz;
    }
}

?>