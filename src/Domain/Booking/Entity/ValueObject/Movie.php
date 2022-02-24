<?php

namespace App\Domain\Booking\Entity\ValueObject;

use DateInterval;
use DomainException;

class Movie
{
    private string $title;
    private DateInterval $duration;

    public function __construct(string $title, string $duration)
    {
        $this->title = $title;

        self::acceptShouldBeConvertStringToTime($duration);
        $this->duration = DateInterval::createFromDateString($duration);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): DateInterval
    {
        return $this->duration;
    }

    private static function acceptShouldBeConvertStringToTime(string $string): void
    {
        if (!strtotime($string)) {
            throw new DomainException('Can\'t convert string to time');
        }
    }
}