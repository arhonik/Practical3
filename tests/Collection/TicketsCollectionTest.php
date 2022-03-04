<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\TicketsCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Customer;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use Monolog\Test\TestCase;
use Symfony\Component\Uid\Uuid;

class TicketsCollectionTest extends TestCase
{
    protected Ticket $ticket;
    protected TicketsCollection $ticketsCollection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ticket = new Ticket(
            Uuid::v4(),
            $this->createMock(MovieShow::class),
            new Customer(
                'Alex',
                '+79021869474'
            ),
            'Venom 2',
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i',
                '2022-10-11 19:45',
                new DateTimeZone('Europe/Moscow')
            )
        );
        $this->ticketsCollection = new TicketsCollection();
    }

    public function testExceptionAddTicket(): void
    {
        $movieShow = $this->createMock(MovieShow::class);

        $this->expectException(DomainException::class);

        $this->ticketsCollection->add($movieShow);
    }

    public function testCorrectAddTicket(): void
    {
        $this->ticketsCollection->add($this->ticket);

        $this->assertCount(1, $this->ticketsCollection);
    }
}