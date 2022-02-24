<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\Ticket;
use Countable;
use Iterator;

class TicketsCollection implements Countable
{
    private array $tickets = [];

    public function get(): array
    {
        return $this->tickets;
    }

    public function add(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    public function count(): int
    {
        return count($this->tickets);
    }

    public function getIterator(): Iterator
    {
        return new TicketsIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new TicketsIterator($this, true);
    }

}