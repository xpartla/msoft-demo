<?php

namespace App\Models;

class Courier
{
    private int $id;
    private string $name;
    private bool $availability;

    public function __construct(int $id, string $name, bool $availability = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->availability = $availability;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function becomeAvailable(): void
    {
        $this->setAvailability(true);
    }
}
