<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use Monolog\Test\TestCase;
use Symfony\Component\Uid\Uuid;

class MovieShowCollectionTest extends TestCase
{
    private MovieShow $movieShow;
    private MovieShowCollection $movieShowCollection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieShow = new MovieShow(
            Uuid::v4(),
            new Movie(
                'Venom 2',
                DateInterval::createFromDateString('1 hour 25 minutes')
            ),
            new Schedule(
                DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 19:45',
                    new DateTimeZone('Europe/Moscow')
                ),
                DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 21:10',
                    new DateTimeZone('Europe/Moscow')
                ),
            ),
            new Hall(
                100
            )
        );
        $this->movieShowCollection = new MovieShowCollection();
    }

    public function testExceptionAddMovieShow(): void
    {
        $ticket = $this->createMock(Ticket::class);

        $this->expectException(DomainException::class);

        $this->movieShowCollection->add($ticket);
    }

    public function testCorrectAddMovieShow(): void
    {
        $this->movieShowCollection->add($this->movieShow);

        $this->assertCount(1, $this->movieShowCollection);
    }
}