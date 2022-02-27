<?php

namespace App\Domain\Booking\Entity\TransferObject;

class BookingDto
{
    public string $name;
    public string $phone;

    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }
}