<?php

namespace App\Models;

class OrderTimeManager
{
    public function getTime(Order $order)
    {
        return $order->getTime();
    }

    public function updateTime(Order $order, $newTime)
    {
        $order->setTime($newTime);
    }
}
