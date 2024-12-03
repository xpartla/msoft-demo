<?php

namespace App\Models;

class Customer
{
    public function acceptChange($orderId)
    {
        echo "<script>alert('Customer accepted the changes for Order #{$orderId}.');</script>";
    }

    public function declineChange($orderId)
    {
        echo "<script>alert('Customer declined the changes for Order #{$orderId}.');</script>";
    }
}
