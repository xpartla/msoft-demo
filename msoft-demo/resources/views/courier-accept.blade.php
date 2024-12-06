<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Availability</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >

</head>
<body>
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
        <?php if ($order->getCourier() > 0): ?>
        <p><strong>Assigned courier ID:</strong> {{ $order->getCourier() }}</p>
        <?php endif; ?>
        <?php if ($order->getCourier() == 0): ?>
        <form action="{{ route('courier-accepted') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Accept Order</button>
        </form>
        <?php endif; ?>
        <?php if ($order->getCourier() > 0 && $navigation == 2): ?>
        <div class="order-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.1158848378454!2d17.103548075918354!3d48.14657105053567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c89acdafd8df1%3A0x5966741dae8763f1!2sKauka!5e0!3m2!1ssk!2ssk!4v1733261015861!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
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
        <?php endif; ?>
        <?php if ($order->getCourier() > 0 && $navigation == 1): ?>
        <div class="order-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.1158848378454!2d17.103548075918354!3d48.14657105053567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c89acdafd8df1%3A0x5966741dae8763f1!2sKauka!5e0!3m2!1ssk!2ssk!4v1733261015861!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <form action="{{ route('markAsPickedUp') }}" method="POST">
            @csrf
            <input type="hidden" name="orderId" value="{{ $order->getId() }}">
            <button type="submit">Pick up order</button>
        </form>
        <?php endif; ?>
        <?php if ($order->getCourier() > 0 && $navigation == 3): ?>
        <div class="order-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2661.760568226931!2d17.068969475918703!3d48.153421050058725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476c8bec79f0f3a9%3A0x8b585229fc0ae860!2sFakulta%20informatiky%20a%20informa%C4%8Dn%C3%BDch%20technol%C3%B3gi%C3%AD%20STU!5e0!3m2!1ssk!2ssk!4v1733475131823!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <?php endif; ?>
    </div>
</div>


</body>
</html>
