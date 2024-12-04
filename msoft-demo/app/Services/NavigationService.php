<?php

namespace App\Services;

use App\Models\NotificationManager;
use App\Models\OrderManager;

class NavigationService
{

    public function showMap($type)
    {
        //only for demo
        return $type;
    }

    public function isNearby($type)
    {
        $this->hasEnoughTime();
        $orderManager = new OrderManager();
        // order details would be fetched from db here
        $orderManager->notifyCourier('3', 'New order available to pick up');
        return $type;
    }

    private function hasEnoughTime()
    {
        //only for demonstration, in real world here would be the calculation if the courier has enough time to pick up a new order
        sleep(1);
        return 1;
    }

}
