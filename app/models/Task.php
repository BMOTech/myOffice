<?php
namespace App\Models;

class Task implements \JsonSerializable
{
    protected $taskID;
    protected $description;

    public function __construct($taskID = null, $description = null) {
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
            'Tasks' => [
                'description' => $this->getDescription(),
            ]
        ];
    }}
?>