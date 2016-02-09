<?php
namespace App\Models;

class Task
{
    protected $taskID;
    protected $description;

    public function __construct($taskID, $description) {
        $this->taskID = $taskID;
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return null
     */
    public function getTaskID()
    {
        return $this->taskID;
    }
}
?>