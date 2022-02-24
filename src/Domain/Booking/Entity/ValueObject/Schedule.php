<?php

namespace App\Domain\Booking\Entity\ValueObject;

use DateTimeInterface;

class Schedule
{
    private DateTimeInterface $startAt;
    private DateTimeInterface $endAt;

    public function __construct(DateTimeInterface $startTime, DateTimeInterface $endTime)
    {
        $this->startAt = $startTime;
        $this->endAt = $endTime;
    }

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function getEndAt(): DateTimeInterface
    {
        return $this->endAt;
    }
}