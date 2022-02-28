<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\Ticket;
use Doctrine\Common\Collections\ArrayCollection;
use DomainException;

class TicketsCollection extends ArrayCollection
{
    public function add(mixed $ticket): void
    {
        self::assertShouldBeMovieShow($ticket);
        parent::add($ticket);
    }

    public static function assertShouldBeMovieShow(mixed $ticket): void
    {
        if (!$ticket instanceof Ticket) {
            throw new DomainException('Invalid object');
        }
    }
}