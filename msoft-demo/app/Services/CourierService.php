<?php

namespace App\Services;

use App\Managers\OrderManager;
use App\Models\Courier;

class CourierService
{
    public function becomeAvailable(Courier $courier): void
    {
        $courier->setAvailability(true);
    }

    public function activateNavigation($type)
    {
        $navigationService = new NavigationService();
        return $navigationService->showMap($type);
    }

    public function checkNearbyOrders($type)
    {
        $orderManager = new OrderManager();
        return $orderManager->check($type);
    }

    public function declineOrder($order)
    {
        $orderManager = new OrderManager();
        $orderManager->decline($order);
    }

    public function whichOrderFirst($order1, $order2)
    {
        $currentOrder = $this->evaluateTime($order1, $order2);
        return $currentOrder->navigate(3);
    }


    public function evaluateTime($order1, $order2)
    {
        return $order1->getTime() < $order2->getTime() ? $order1 : $order2;
    }
}
