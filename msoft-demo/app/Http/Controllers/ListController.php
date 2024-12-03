<?php

namespace App\Http\Controllers;

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
        $this->orderManager->addOrder(new Order(1, 'Pending', 30));
        $this->orderManager->addOrder(new Order(2, 'In Progress', 20));
        $this->orderManager->addOrder(new Order(3, 'Completed', 0));
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
}
