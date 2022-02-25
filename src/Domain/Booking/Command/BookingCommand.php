<?php

namespace App\Domain\Booking\Command;

class BookingCommand
{
    public string $name;
    public string $phone;
    public string $movieShow;

    public function load(string $name, string $phone, string $movieShow)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->movieShow = $movieShow;
    }
}