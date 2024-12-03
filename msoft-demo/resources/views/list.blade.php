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
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Active Orders</h1>
<ul class="order-list">
    @foreach ($activeOrders as $order)
        <li>
            <a href="#" class="order-link" data-id="{{ $order->getId() }}">
                Order #{{ $order->getId() }} ({{ $order->getStatus() }}) Time remaining: {{ $order->getTime() }} min.
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
    <button onclick="cancelChange()">Cancel</button>
    <h3>Items</h3>
    <ul id="detail-items" style="list-style: none; padding: 0;"></ul>
</div>

<div>
    <a href="{{ route('customer.pov') }}" class="button">Customer POV</a>
    <a href="{{ route('courier.pov') }}" class="button">Courier POV</a>
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
                    const { id, status, time, items } = data.data;
                    document.getElementById('detail-id').textContent = id;
                    document.getElementById('detail-status').textContent = status;
                    document.getElementById('detail-time').textContent = time;
                    document.getElementById('time-input').value = time;

                    // Clear existing items
                    const itemsList = document.getElementById('detail-items');
                    itemsList.innerHTML = '';

                    // Populate items
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = `${item.name} - $${item.price} (${item.weight}g)`;
                        itemsList.appendChild(li);
                    });

                    document.getElementById('order-details').style.display = 'block';
                } else {
                    alert(data.message);
                }
            });
    }

    function updateTime() {
        const orderId = parseInt(document.getElementById('detail-id').textContent);
        const newTime = parseInt(document.getElementById('time-input').value);

        if (newTime > 45) {
            fetch('/show-error-message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message: 'Order time cannot exceed 45 minutes.' })
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Error showing error message.');
                    }
                });
            alert('Order time cannot exceed 45 minutes.');
            return;
        }

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

    function cancelChange() {
        document.getElementById('time-input').value = document.getElementById('detail-time').textContent;
        alert('Changes canceled.');
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
