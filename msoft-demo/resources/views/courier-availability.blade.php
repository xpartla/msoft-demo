<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Availability</title>
</head>
<body>
<h1>Courier Availability</h1>

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

<!-- Button to accept order -->
<form action="{{ route('accept-order') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Accept Order</button>
</form>

<form action="{{ route('courier-preaccept') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Switch to Courier view</button>
</form>
</body>
</html>