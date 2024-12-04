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

<?php if ($navigation == null): ?>
<form action="{{ route('acceptOrder') }}" method="POST">
    @csrf
    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
    <button type="submit">Activate navigation</button>
</form>
<?php endif; ?>
<?php if ($navigation == 1 || $navigation == 2): ?>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.1158848378454!2d17.103548075918354!3d48.14657105053567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c89acdafd8df1%3A0x5966741dae8763f1!2sKauka!5e0!3m2!1ssk!2ssk!4v1733261015861!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <?php if (!$nearbyOrder): ?>
    <form action="{{ route('nearbyOrder') }}" method="POST">
        @csrf
        <input type="hidden" name="orderId" value="{{ $order->getId() }}">
        <button type="submit">Demonstrate nearby order</button>
    </form>
   <?php endif; ?>
<?php endif; ?>
<?php if ($nearbyOrder): ?>
<p><strong>Order ID:</strong> {{ $nearbyOrder->getId() }}</p>
<p><strong>Status:</strong> {{ $nearbyOrder->getStatus() }}</p>
<p><strong>Time:</strong> {{ $nearbyOrder->getTime() }} minutes</p>
<p><strong>Items:</strong></p>
<ul>
    @foreach ($nearbyOrder->getItems() as $item)
        <li>{{ $item->getName() }} - ${{ $item->getPrice() }} ({{ $item->getWeight() }} g)</li>
    @endforeach
</ul>
    <?php if ($nearbyOrder->getCourier() > 0): ?>
    <p><strong>Assigned courier ID:</strong> {{ $nearbyOrder->getCourier() }}</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2661.9439630331676!2d17.132372375918557!3d48.149885550304845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c895ba6dd6417%3A0x1ef3561ee1d13ed1!2zR29yaWZmZWUgS2_FoWlja8Oh!5e0!3m2!1ssk!2ssk!4v1733330250460!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <?php if ($nearbyOrder->getStatus() != 'Prepared' && $nearbyOrder->getStatus() != 'Picked Up'): ?>
            <form action="{{ route('changeState') }}" method="POST">
                @csrf
                <input type="hidden" name="orderId" value="{{ $order->getId() }}">
                <button type="submit">Demonstrate Order Preparation</button>
            </form>
        <?php endif; ?>
            <?php if ($nearbyOrder->getStatus() == 'Prepared'): ?>
                <form action="{{ route('nearbyOrderIsPrepared') }}" method="POST">
                    @csrf
                    <input type="hidden" name="orderId" value="{{ $order->getId() }}">
                    <button type="submit">Pick up Order</button>
                </form>
            <?php endif; ?>
   <?php endif; ?>
    <?php if ($nearbyOrder->getCourier() == 0): ?>
        <form action="{{ route('acceptSecondOrder') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Accept Order</button>
        </form>
        <form action="{{ route('declineSecondOrder') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Decline Order</button>
        </form>
    <?php endif; ?>


<?php endif; ?>
</body>
</html>
