<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use DomainException;
use Monolog\Test\TestCase;
use Symfony\Component\Uid\Uuid;

class MovieShowCollectionTest extends TestCase
{
    protected MovieShow $movieShow;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieShow = new MovieShow(
            Uuid::v4(),
            new Movie(
                'Venom 2',
                \DateInterval::createFromDateString('1 hour 25 minutes')
            ),
            new Schedule(
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 19:45',
                    new \DateTimeZone('Europe/Moscow')
                ),
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 21:10',
                    new \DateTimeZone('Europe/Moscow')
                ),
            ),
            new Hall(
                100
            )
        );
    }

    public function testExceptionAddMovieShow(): void
    {
        $moveShowCollection = new MovieShowCollection();

        $ticket = $this->createMock(Ticket::class);
        $this->expectException(DomainException::class);
        $moveShowCollection->add($ticket);
    }

    public function testCorectAddMovieShow(): void
    {
        $moveShowCollection = new MovieShowCollection();
        $moveShowCollection->add($this->movieShow);
        $this->assertCount(1, $moveShowCollection);
    }
}