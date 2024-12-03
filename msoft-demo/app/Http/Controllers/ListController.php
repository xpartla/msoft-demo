<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Customer;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\OrderManager;
use Illuminate\Http\Request;

class ListController extends Controller
{
    private $orderManager;


    public function __construct()
    {
        // Initialize OrderManager with mock data
        $this->orderManager = new OrderManager();

        // Create food items
        $foodItemsOrder1 = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300),
        ];

        $foodItemsOrder2 = [
            new FoodItem('Pizza', 15, 400),
            new FoodItem('Garlic Bread', 7, 250),
        ];

        $foodItemsOrder3 = [
            new FoodItem('Pasta', 12, 300),
            new FoodItem('Salad', 6, 100),
        ];

        // Add orders with food items
        $this->orderManager->addOrder(new Order(1, 'Pending', 30, $foodItemsOrder1));
        $this->orderManager->addOrder(new Order(2, 'In Progress', 20, $foodItemsOrder2));
        $this->orderManager->addOrder(new Order(3, 'Completed', 0, $foodItemsOrder3));
    }

    public function index()
    {
        // Get active orders
        $activeOrders = collect($this->orderManager->getActiveOrders());

        return view('list', compact('activeOrders'));
    }

    public function getOrderDetail(Request $request)
    {
        $orderId = $request->input('orderId');
        $orderDetail = $this->orderManager->getOrderDetail($orderId);

        if ($orderDetail) {
            return response()->json(['success' => true, 'data' => $orderDetail]);
        }

        return response()->json(['success' => false, 'message' => 'Order not found']);
    }

    public function updateOrderTime(Request $request)
    {
        $orderId = $request->input('orderId');
        $newTime = $request->input('newTime');

        $this->orderManager->setOrderTime($orderId, $newTime);

        return response()->json(['success' => true, 'message' => 'Order time updated']);
    }

    public function customerPov()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];

        $order = new Order(1, 'Pending', 30, $foodItems);
        $orderManager = new OrderManager();
        $orderManager->notifyCustomer($order->getId(), 'Order time has been updated to 15 minutes.');

        // Pass order to the customer view
        return view('customer-pov', compact('order'));
    }

    public function courierPov()
    {
        $foodItems = [
            new FoodItem('Pizza', 15, 400),
            new FoodItem('Garlic Bread', 7, 250)
        ];

        $order = new Order(2, 'In Progress', 20, $foodItems);
        $orderManager = new OrderManager();
        $orderManager->notifyCourier($order->getId(), 'Order time has been updated to 10 minutes.');

        // Pass order to the courier view
        return view('courier-pov', compact('order'));
    }
}
