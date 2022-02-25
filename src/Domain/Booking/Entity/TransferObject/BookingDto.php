<?php

namespace App\Domain\Booking\Entity\TransferObject;

class BookingDto
{
    public string $name;
    public string $phone;
    public string $movieShow;

    public function __construct(string $name, string $phone, string $movieShow)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->movieShow = $movieShow;
    }
}