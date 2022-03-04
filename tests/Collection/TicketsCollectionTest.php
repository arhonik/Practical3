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
        $this->ticketsCollection->add($this->getTicket());

        $this->assertCount(1, $this->ticketsCollection);
    }

    private function getTicket(): Ticket
    {
        return $this->createMock(Ticket::class);
    }
}