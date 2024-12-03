<?php

namespace App\Models;

use App\Services\NavigationService;

class Order
{
    private $id;
    private $status;
    private $time;
    private $items;
    private $courier;

    public function __construct($id, $status, $time, $items, $courier)
    {
        $this->id = $id;
        $this->status = $status;
        $this->time = $time;
        $this->items = $items;
        $this->courier = $courier;
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

    public function changeState($newState)
    {
        $this->status = $newState;
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

    public function getCourier()
    {
        return $this->courier;
    }

    public function assignCourier($courierId)
    {
        $this->courier = $courierId;
    }
    public function navigate($type)
    {
        // only for demonstration, real world application would have logic for calculating navigation
        $navigationService = new NavigationService();
        return $navigationService->showMap($type);
    }

    public function isPrepared()
    {
        $this->setStatus('Prepared');
        return 'Prepared';
    }
}


