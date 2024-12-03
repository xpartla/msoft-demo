<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer POV</title>
</head>
<body>
<h1>Customer POV</h1>
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
<button onclick="declineChange()">Decline Change</button>

<script>
    function acceptChange() {
        alert('Accepted changes!');
    }

    function declineChange() {
        alert('Declined changes!');
    }
</script>

</body>
</html>
