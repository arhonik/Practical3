<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Hall
{
    #[ORM\Column(type: 'integer')]
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