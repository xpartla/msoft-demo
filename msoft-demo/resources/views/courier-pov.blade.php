<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier POV</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
</head>
<body>
<div class="order-card">
    <div class="order-details">
        <h2>Order #{{ $order->getId() }} - Status: {{ $order->getStatus() }}</h2>
        <p>Time Remaining: {{ $order->getTime() }} minutes</p>

        <h3>Order Contents:</h3>
        <ul>
            @foreach ($order->getItems() as $item)
                <li>
                    {{ $item->getName() }} - ${{ $item->getPrice() }} ({{ $item->getWeight() }}g)
                </li>
            @endforeach
        </ul>

        <button onclick="acceptChange()">Accept Change</button>
    </div>
</div>


<script>
    function acceptChange() {
        alert('Accepted changes!');
    }
</script>
</body>
</html>
