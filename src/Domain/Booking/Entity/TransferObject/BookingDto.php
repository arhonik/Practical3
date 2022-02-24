<?php

namespace App\Domain\Booking\Entity\TransferObject;

class BookingDto
{
    public string $name;
    public string $phone;
    public string $movieShow;

    public function load(?array $data): void
    {
        self::assertCanBeArray($data);

        $this->name = $data["name"];
        $this->phone = $data["phone"];
        $this->movieShow = $data["movieShow"];
    }

    private static function assertCanBeArray(?array $data): void
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Error type');
        }
    }
}