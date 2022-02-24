<?php

namespace App\Domain\Booking\Entity\ValueObject;

use DateInterval;

class Movie
{
    private string $title;
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