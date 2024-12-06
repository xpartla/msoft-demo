<?php

namespace App\Managers;

class NotificationManager
{
    public function notify($userType, $message)
    {
        echo "<script>alert('{$userType}: {$message}');</script>";
    }
}
