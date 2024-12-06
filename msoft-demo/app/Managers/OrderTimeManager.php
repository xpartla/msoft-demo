<?php

namespace App\Managers;

use App\Models\Order;

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
