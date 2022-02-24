<?php

namespace App\Domain\Booking\Entity\ValueObject;

use DateInterval;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Movie
{
    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'dateinterval')]
    private DateInterval $duration;

    public function __construct(string $title, DateInterval $duration)
    {
        $this->title = $title;
        $this->duration = $duration;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): DateInterval
    {
        return $this->duration;
    }
}