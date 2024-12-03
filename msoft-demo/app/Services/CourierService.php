<?php

namespace App\Services;

use App\Models\Courier;

class CourierService
{
    public function becomeAvailable(Courier $courier): void
    {
        $courier->setAvailability(true);
        // Add additional logic if needed, such as logging or notifications.
    }
}
