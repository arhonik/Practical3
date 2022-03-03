<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Collection\TicketsCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use DomainException;
use Symfony\Component\Uid\Uuid;

class TicketsCollectionTest extends \Monolog\Test\TestCase
{
    protected Ticket $ticket;

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
            \DateTimeImmutable::createFromFormat(
                'Y-m-d H:i',
                '2022-10-11 19:45',
                new \DateTimeZone('Europe/Moscow')
            )
        );
    }

    public function testExceptionAddTicket(): void
    {
        $ticketsCollection = new TicketsCollection();

        $movieShow = $this->createMock(MovieShow::class);
        $this->expectException(DomainException::class);
        $ticketsCollection->add($movieShow);
    }

    public function testCorrectAddTicket(): void
    {
        $ticketsCollection = new TicketsCollection();
        $ticketsCollection->add($this->ticket);
        $this->assertCount(1, $ticketsCollection);
    }
}