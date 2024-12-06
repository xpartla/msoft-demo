<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Availability</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >

</head>
<body>
<h1>Restaurant View</h1>

<div class="order-card">
    <div class="order-details">
        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> {{ $order->getId() }}</p>
        <p><strong>Status:</strong> {{ $order->getStatus() }}</p>
        <p><strong>Time:</strong> {{ $order->getTime() }} minutes</p>
        <p><strong>Items:</strong></p>
        <ul>
            @foreach ($order->getItems() as $item)
                <li>{{ $item->getName() }} - ${{ $item->getPrice() }} ({{ $item->getWeight() }} g)</li>
            @endforeach
        </ul>
        <?php if($buttonHelper == 1): ?>
        <form action="{{ route('accept-order') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Accept Order</button>
        </form>
        <?php endif; ?>

        <?php if($buttonHelper == 2): ?>
        <form action="{{ route('courier-preaccept') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Switch to Courier view</button>
        </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
