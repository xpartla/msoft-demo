<?php
namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderManager;

class OrderController extends Controller
{
    public function acceptOrder(Request $request)
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $orderManager = new OrderManager();

        $order = new Order(1, $orderManager->acceptOrder(1), 30, $foodItems, 0);
        $orderManager->acceptOrder(1);
        $orderManager->notifyCustomer($order->getId(), 'Notification sent to customer, order has been accepted.');

        return view('courier-availability', compact('order'));
    }

    public function prepareAcceptOrder(Request $request)
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $order = new Order(1, 'Available', 30, $foodItems, 0);
        return view('courier-accept', compact('order'));
    }

    public function cacceptOrder(Request $request)
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $orderManager = new OrderManager();

        $orderManager->acceptOrder(1);
        $order = new Order(1, $orderManager->acceptOrder(1), 30, $foodItems, $orderManager->assignCourier(1, 1));
        $orderManager->notifyCustomer($order->getId(), 'Notification sent to customer, order has been accepted.');
        $navigation = $order->navigate(2);
        return view('courier-accept', compact('order', 'navigation'));
    }

}
