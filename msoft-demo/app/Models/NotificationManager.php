<?php

namespace App\Models;

class NotificationManager
{
    public function notify($userType, $message)
    {
        // Display a notification based on user type (Customer or Courier)
        echo "<script>alert('{$userType}: {$message}');</script>";
    }
}
