<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign and Pick Up</title>
</head>
<body>
<h1>Courier POV</h1>

<!-- Display Courier Details -->
<p><strong>Courier Name:</strong> {{ $courier->getName() }}</p>
<p><strong>Courier ID:</strong> {{ $courier->getId() }}</p>
<p><strong>Availability:</strong> {{ $courier->isAvailable() ? 'Available' : 'Unavailable' }}</p>

<!-- Button to Make Available -->
<?php if (!$courier->isAvailable()): ?>
<form action="{{ route('make-available') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $courier->getId() }}">
    <button type="submit">Become Available</button>
</form>
<?php endif;?>

</body>
</html>
