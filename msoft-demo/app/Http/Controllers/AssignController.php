<?php

namespace App\Http\Controllers;

use App\Managers\OrderManager;
use App\Models\Courier;
use App\Models\FoodItem;
use App\Models\Order;
use App\Services\CourierService;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    private OrderManager $orderManager;
    private CourierService $courierService;
    private ?Order $order = null;
    private ?Order $nearbyOrder = null;

    public function __construct(OrderManager $orderManager, CourierService $courierService)
    {
        $this->orderManager = $orderManager;
        $this->courierService = $courierService;
        $this->initializeOrders();

    }
    private function initializeOrders(): void
    {
        $foodItems = [
            new FoodItem('Coffee', 10, 200),
            new FoodItem('Cake', 5, 150)
        ];
        $this->order = new Order(1, 'Assigned', 25, $foodItems, 1);

        $foodItemsSecondOrder = [
            new FoodItem('Pizza', 10, 450),
        ];
        $this->nearbyOrder = new Order(3, 'Assigned', 20, $foodItemsSecondOrder, 1);
    }

    public function index()
    {
        $courier = new Courier(1, 'John Doe', false);

        return view('assign-and-pickup', ['courier' => $courier]);
    }

    public function cancelOrder(){
        $courier = new Courier(1, 'John Doe', true);
        $this->orderManager->cancelOrder(1);
        return view('assign-and-pickup', ['courier' => $courier]);
    }

    public function makeAvailable(Request $request)
    {
        $id = $request->input('id');
        $courier = new Courier($id, 'John Doe', false); // Mocking the same courier for simplicity

        $this->courierService->becomeAvailable($courier);

        return redirect()->route('courier-availability')->with('success', 'Courier is now available.');
    }

    public function courierAvailability()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $buttonHelper = 1;
        $order = new Order(1, 'Pending', 30, $foodItems, 0);

        return view('courier-availability', compact('order', 'buttonHelper'));
    }

    public function isPrepared()
    {

        $order = $this->order;
        $order->setStatus('Prepared');
        $order->setTime('20');
        $order->isPrepared();
        $navigation = $order->navigate(1);
        return view('courier-accept', compact('order', 'navigation'));
    }

    public function markAsPickedUp()
    {
        $order = $this->order;
        $order->setStatus($this->orderManager->markAsPickedUp($order));
        $order->setTime('15');
        $navigation = $order->navigate(3);
        return view('courier-accept', compact('order', 'navigation'));
    }
}
