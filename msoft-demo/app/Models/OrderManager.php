<?php

namespace App\Models;

use App\Services\NavigationService;

class OrderManager
{
    private $orders;
    private $orderTimeManager;
    private $notificationManager;

    public function __construct()
    {
        $this->orders = [];
        $this->orderTimeManager = new OrderTimeManager();
        $this->notificationManager = new NotificationManager();
    }

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    public function getActiveOrders()
    {
        // Filter active orders (assuming "Completed" is not active)
        return array_filter($this->orders, function (Order $order) {
            return $order->getStatus() !== 'Completed';
        });
    }

    public function getOrderTime($orderId)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            return $this->orderTimeManager->getTime($order);
        }
        return null;
    }

    public function getOrderDetail($orderId)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            return [
                'id' => $order->getId(),
                'status' => $order->getStatus(),
                'time' => $order->getTime(),
                'items' => $order->getItems(),
            ];
        }
        return null;
    }

    public function setOrderTime($orderId, $newTime)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            $this->orderTimeManager->updateTime($order, $newTime);
        }
    }

    public function findOrderById($orderId)
    {
        foreach ($this->orders as $order) {
            if ($order->getId() === $orderId) {
                return $order;
            }
        }
        return null;
    }

    public function notifyCustomer($orderId, $message)
    {
        $this->notificationManager->notify('Customer', $message);
    }

    public function notifyCourier($orderId, $message)
    {
        $this->notificationManager->notify('Courier', $message);
    }

    public function showErrorMessage($message)
    {
        echo "<script>alert('$message');</script>";
    }

    public function cancelChange()
    {
        echo "<script>alert('Changes canceled.');</script>";
    }

    public function acceptOrder($orderId)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            $order->setStatus('Accepted'); // Call `changeState` method in `Order`
            echo "<script>alert('Order #{$orderId} has been accepted.');</script>";
        }
        return 'Accepted';
    }

    public function assignCourier($orderId, $courierId)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            $order->assignCourier($courierId);
        }
        return 1;
    }

    public function cancelOrder($orderId)
    {
        $this->notifyCourier($orderId, 'Order has been canceled by restaurant worker.');
    }
    public function markAsPickedUp($order)
    {
        $order->setStatus('Picked Up');

        $this->notifyCustomer($order->getId(), "Customer was notified about the order pickup.");

        return 'Picked Up';
    }

    public function check($type)
    {
        $navigationService = new NavigationService();
        $navigationService->isNearby($type);
        $foodItems = [
            new FoodItem('Pizza', 10, 450),
        ];

        return new Order(3,'Available', 35, $foodItems, 0);
    }

    public function decline($order)
    {
        $this->blackListCourier($order->getId());
        return $order;
    }

    public function blackListCourier($id)
    {
        //logic to not allow courier to see the order
        return 0;
    }

    public function changeState($orderId)
    {
        $order = $this->findOrderById($orderId);
        if ($order) {
            $order->setStatus('Prepared');
        }
        return 'Prepared';
    }

    public function checkTime($order1, $order2)
    {
        return $order1->getTime() < $order2->getTime() ? $order1 : $order2;
    }
}
