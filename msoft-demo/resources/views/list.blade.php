<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; }
        .order-list { list-style-type: none; padding: 0; }
        .order-list li { margin: 10px 0; }
        .order-details { margin-top: 20px; padding: 10px; border: 1px solid #ccc; display: none; }
    </style>
</head>
<body>
<h1>Active Orders</h1>
<ul class="order-list">
    @foreach ($activeOrders as $order)
        <li>
            <a href="#" class="order-link" data-id="{{ $order->getId() }}">
                Order #{{ $order->getId() }} ({{ $order->getStatus() }})
            </a>
        </li>
    @endforeach
</ul>

<div id="order-details" class="order-details">
    <h2>Order Details</h2>
    <p><strong>Order ID:</strong> <span id="detail-id"></span></p>
    <p><strong>Status:</strong> <span id="detail-status"></span></p>
    <p><strong>Time Remaining:</strong> <span id="detail-time"></span> minutes</p>
    <label for="time-input">Edit Remaining Time:</label>
    <input type="number" id="time-input" min="0" />
    <button onclick="updateTime()">Save</button>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showDetails(orderId) {
        fetch('/get-order-detail', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ orderId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const { id, status, time } = data.data;
                    document.getElementById('detail-id').textContent = id;
                    document.getElementById('detail-status').textContent = status;
                    document.getElementById('detail-time').textContent = time;
                    document.getElementById('time-input').value = time;

                    document.getElementById('order-details').style.display = 'block';
                } else {
                    alert(data.message);
                }
            });
    }

    function updateTime() {
        const orderId = parseInt(document.getElementById('detail-id').textContent);
        const newTime = parseInt(document.getElementById('time-input').value);

        fetch('/update-order-time', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ orderId, newTime })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('detail-time').textContent = newTime;
                    alert(data.message);
                } else {
                    alert('Failed to update order time.');
                }
            });
    }

    document.querySelectorAll('.order-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const orderId = parseInt(this.getAttribute('data-id'));
            showDetails(orderId);
        });
    });
</script>
</body>
</html>
