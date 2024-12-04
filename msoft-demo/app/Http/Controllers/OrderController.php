<?php
namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Order;
use App\Services\CourierService;
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

    public function twoOrders()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $navigation = null;
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierAcceptOrder()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $courierService = new CourierService();
        $navigation = $courierService->activateNavigation(1);
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function checkNearbyOrders()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $courierService = new CourierService();
        $navigation = $courierService->activateNavigation(1);
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $nearbyOrder = $courierService->checkNearbyOrders(1);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierAcceptSecondOrder()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $courierService = new CourierService();
        $orderManager = new OrderManager();
        $navigation = 1;
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $foodItemsSecondOrder = [
            new FoodItem('Pizza', 10, 450),
        ];
        $navigation = $order->navigate(2);
        $nearbyOrder =  new Order(3,$orderManager->acceptOrder(3), 20, $foodItemsSecondOrder, $orderManager->assignCourier(3,1));
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function courierDeclineSecondOrder()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $courierService = new CourierService();
        $navigation = 1;
        $order = new Order(3,'Assigned', 25, $foodItems, 1);
        $foodItemsSecondOrder = [
            new FoodItem('Pizza', 10, 450),
        ];
        $nearbyOrder = new Order(1,'Assigned', 20, $foodItemsSecondOrder, 1);
        $courierService->declineOrder($nearbyOrder);
        $nearbyOrder = null;
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function changeState()
    {
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $orderManager = new OrderManager();
        $order = new Order(1,'Assigned', 25, $foodItems, 1);
        $foodItemsSecondOrder = [
            new FoodItem('Pizza', 10, 450),
        ];
        $navigation = 2;
        $nearbyOrder =  new Order(3,$orderManager->changeState(3), 20, $foodItemsSecondOrder, 1);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }

    public function nearbyOrderIsPrepared()
    {
        $orderManager = new OrderManager();
        $foodItems = [
            new FoodItem('Burger', 10, 200),
            new FoodItem('Fries', 5, 150),
            new FoodItem('Soda', 3, 300)
        ];
        $order = new Order(1, 'Assigned', 25, $foodItems, 1);
        $foodItemsSecondOrder = [
            new FoodItem('Pizza', 10, 450),
        ];
        $nearbyOrder =  new Order(3,'Assigned', 20, $foodItemsSecondOrder, 1);
        $orderManager->markAsPickedUp($nearbyOrder);
        $courierService = new CourierService();
        $navigation = $courierService->whichOrderFirst($order, $nearbyOrder);
        return view('two-orders', compact('order', 'navigation', 'nearbyOrder'));
    }
}
