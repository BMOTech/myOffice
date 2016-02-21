<?php
namespace App\Models;

class Event implements \JsonSerializable
{
    protected $id;
    protected $title;
    protected $start;
    protected $text;

    public function __construct($id = null, $title = null, $start = null, $text = null)
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
            'Events' => [
                'title' => $this->getTitle(),
                'start' => $this->getStart()
            ]
        ];
    }}