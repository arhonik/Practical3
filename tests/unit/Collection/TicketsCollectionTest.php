<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\TicketsCollection;
use App\Domain\Booking\Entity\Ticket;
use DomainException;
use Monolog\Test\TestCase;
use stdClass;

class TicketsCollectionTest extends TestCase
{
    private TicketsCollection $ticketsCollection;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketsCollection = new TicketsCollection();
    }

    public function testExceptionAddTicket(): void
    {
        $object = new stdClass();

        $this->expectException(DomainException::class);

        $this->ticketsCollection->add($object);
    }

    public function testCorrectAddTicket(): void
    {
        $ticket = $this->createMock(Ticket::class);

        $this->ticketsCollection->add($ticket);

        $this->assertCount(1, $this->ticketsCollection);
        $this->assertEquals($ticket, $this->ticketsCollection->first());
    }
}