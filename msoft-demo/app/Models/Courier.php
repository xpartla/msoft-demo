<?php

namespace App\Models;

class Courier extends User
{
    private bool $availability;

    public function __construct(int $id, string $name, bool $availability = false)
    {
        parent::__construct($id,$name);
        $this->availability = $availability;
    }

    public function isAvailable(): bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): void
    {
        $this->availability = $availability;
    }

    public function acceptChange(int $orderId): void
    {
        echo "<script>alert('Courier accepted the changes for Order #{$orderId}.');</script>";
    }

}
