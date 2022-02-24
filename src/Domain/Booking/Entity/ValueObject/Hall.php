<?php

namespace App\Domain\Booking\Entity\ValueObject;

class Hall
{
    private int $numberOfPlaces;

    public function __construct(int $numberOfPlaces)
    {
        $this->numberOfPlaces = $numberOfPlaces;
    }

    public function getNumberOfPlaces(): int
    {
        return $this->numberOfPlaces;
    }
}