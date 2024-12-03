<?php

namespace App\Models;

class Order
{
    private $id;
    private $status;
    private $time;

    public function __construct($id, $status, $time)
    {
        $this->id = $id;
        $this->status = $status;
        $this->time = $time;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }
}
