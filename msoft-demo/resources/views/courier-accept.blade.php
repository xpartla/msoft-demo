<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Availability</title>
</head>
<body>
<h1>Courier POV</h1>

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
<?php if ($order->getCourier() > 0): ?>
<p><strong>Assigned courier ID:</strong> {{ $order->getCourier() }}</p>
<?php endif; ?>

<!-- Button to accept order -->
<?php if ($order->getCourier() == 0): ?>
<form action="{{ route('courier-accepted') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Accept Order</button>
</form>
<?php endif; ?>

<?php if ($order->getCourier() > 0 && $navigation > 0): ?>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.1158848378454!2d17.103548075918354!3d48.14657105053567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c89acdafd8df1%3A0x5966741dae8763f1!2sKauka!5e0!3m2!1ssk!2ssk!4v1733261015861!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

<form action="{{ route('assign') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Demonstrate restaurant cancellation</button>
</form>
<form action="{{ route('orderIsPrepared') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Demonstrate order preparation</button>
</form>
<form action="{{ route('markAsPickedUp') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Pick up order</button>
</form>
<?php endif; ?>
</body>
</html>
