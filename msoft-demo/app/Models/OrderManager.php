<?php

namespace App\Models;

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

    private function findOrderById($orderId)
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
}
