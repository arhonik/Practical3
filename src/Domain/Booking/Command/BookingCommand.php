<?php

namespace App\Domain\Booking\Command;

use Symfony\Component\Validator\Constraints as Assert;

class BookingCommand
{
    #[Assert\Uuid]
    #[Assert\NotBlank]
    public string $movieShowId;

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Regex('/^(\+7|8)\d{10}$/')]
    public string $phone;
}