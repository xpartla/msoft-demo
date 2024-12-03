<?php

namespace App\Models;

class Courier
{
    public function acceptChange($orderId)
    {
        echo "<script>alert('Courier accepted the changes for Order #{$orderId}.');</script>";
    }
}
