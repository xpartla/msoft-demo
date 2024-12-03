<?php

namespace App\Models;

class Order
{
    private $id;
    private $status;
    private $time;
    private $items;

    public function __construct($id, $status, $time, $items)
    {
        $this->id = $id;
        $this->status = $status;
        $this->time = $time;
        $this->items = $items;
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

    public function addItem(FoodItem $item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }
}


