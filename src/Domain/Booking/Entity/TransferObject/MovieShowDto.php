<?php

namespace App\Domain\Booking\Entity\TransferObject;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

class MovieShowDto
{
    public string $titleMovie;
    public DateTimeInterface $startTime;

    public function load(?array $data): void
    {
        self::assertCanBeArray($data);

        $this->titleMovie = $data["titleMovie"];
        $this->startTime = DateTimeImmutable::createFromFormat(
            "Y-m-d H:i",
            $data["startTime"],
            new DateTimeZone("Europe/Moscow")
        );
    }

    private static function assertCanBeArray(?array $data): void
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Error type');
        }
    }
}