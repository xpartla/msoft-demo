<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\OrderManager;
use App\Services\CourierService;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    protected $courierService;

    public function __construct(CourierService $courierService)
    {
        $this->courierService = $courierService;
    }

    public function index()
    {
        // Create a mock courier instance
        $courier = new Courier(1, 'John Doe', false);

        // Pass the courier to the view
        return view('assign-and-pickup', ['courier' => $courier]);
    }

    public function cancelOrder(){
        $courier = new Courier(1, 'John Doe', true);
        $orderManager = new OrderManager();
        $orderManager->cancelOrder(1);
        // Pass the courier to the view
        return view('assign-and-pickup', ['courier' => $courier]);
    }

    public function makeAvailable(Request $request)
    {
        // Retrieve the courier instance based on the submitted ID
        $id = $request->input('id');
        $courier = new Courier($id, 'John Doe', false); // Mocking the same courier for simplicity

        // Mark the courier as available
        $this->courierService->becomeAvailable($courier);

        // Redirect to the new page
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
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];

        $order = new Order(1, 'Prepared', 20, $foodItems, 1);
        $order->isPrepared();
        $navigation = $order->navigate(1);
        return view('courier-accept', compact('order', 'navigation'));
    }

    public function markAsPickedUp()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];

        $order = new Order(1, 'Picked Up', 20, $foodItems, 1);
        $orderManager = new OrderManager();
        $orderManager->markAsPickedUp($order);
        $navigation = $order->navigate(3);
        return view('courier-accept', compact('order', 'navigation'));
    }
}
