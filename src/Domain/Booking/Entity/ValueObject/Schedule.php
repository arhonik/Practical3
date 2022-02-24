<?php

namespace App\Domain\Booking\Entity\ValueObject;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Schedule
{
    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $startAt;

    #[ORM\Column(type: 'datetime')]
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