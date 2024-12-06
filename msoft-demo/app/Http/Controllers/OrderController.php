<?php
namespace App\Http\Controllers;

use App\Managers\OrderManager;
use App\Models\FoodItem;
use App\Models\Order;
use App\Services\CourierService;
use Illuminate\Http\Request;

class OrderController extends Controller
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
    public function acceptOrder(Request $request)
    {
        $order = $this->order;

        $this->orderManager->acceptOrder($order->getId());
        $order->setStatus('Accepted');
        $this->orderManager->notifyCustomer($order->getId(), 'Notification sent to customer, order has been accepted.');
        $buttonHelper = 2;

        return view('courier-availability', compact('order', 'buttonHelper'));
    }

    public function prepareAcceptOrder(Request $request)
    {
        $order = $this->order;
        $order->setStatus('Available');
        $order->assignCourier(0);
        return view('courier-accept', compact('order'));
    }

    public function cacceptOrder(Request $request)
    {
        $order = $this->order;
        $order->setStatus($this->orderManager->acceptOrder(1));
        $order->assignCourier($this->orderManager->assignCourier(1, 1));
        $this->orderManager->notifyCustomer($order->getId(), 'Notification sent to customer, order has been accepted.');
        $navigation = $order->navigate(2);
        return view('courier-accept', compact('order', 'navigation'));
    }

    public function twoOrders()
    {
        $foodItems = [
            new FoodItem('Coffee', 10, 200),
            new FoodItem('Cake', 5, 150)
        ];
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $navigation = null;
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierAcceptOrder()
    {
        $order = $this->order;
        $navigation = $this->courierService->activateNavigation($order->getId());
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function checkNearbyOrders()
    {
        $navigation = $this->courierService->activateNavigation(1);
        $order = $this->order;
        $nearbyOrder = $this->courierService->checkNearbyOrders(1);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierAcceptSecondOrder()
    {
        $order = $this->order;
        $nearbyOrder = $this->nearbyOrder;
        $nearbyOrder->setStatus($this->orderManager->acceptOrder(3));
        $nearbyOrder->assignCourier($this->orderManager->assignCourier(3,1));
        $navigation = $order->navigate(2);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierDeclineSecondOrder()
    {
        $order = $this->order;
        $nearbyOrder = $this->nearbyOrder;
        $this->courierService->declineOrder($nearbyOrder);
        $navigation = 1;
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function changeState()
    {
        $navigation = 2;
        $order = $this->order;
        $nearbyOrder = $this->nearbyOrder;
        $nearbyOrder->setStatus($this->orderManager->changeState(3));
        $nearbyOrder->setTime(20);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function nearbyOrderIsPrepared()
    {
        $order = $this->order;
        $nearbyOrder = $this->nearbyOrder;
        $nearbyOrder->setTime(15);
        $this->orderManager->markAsPickedUp($nearbyOrder);
        $navigation = $this->courierService->whichOrderFirst($order, $nearbyOrder);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }
}
