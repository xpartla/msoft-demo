<?php

namespace App\Services;

use App\Models\Courier;
use App\Models\OrderManager;

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
        $orderManager = new OrderManager();
        $currentOrder = $orderManager->checkTime($order1, $order2);
        return $currentOrder->navigate(3);
    }
}
