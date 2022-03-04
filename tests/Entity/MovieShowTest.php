<?php

namespace App\Tests\Entity;

use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use Monolog\Test\TestCase;
use Symfony\Component\Uid\Uuid;

class MovieShowTest extends TestCase
{
    protected MovieShow $movieShow;
    protected BookingDto $bookingDto;

    public function setUp(): void
    {
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
                1
            )
        );

        $this->bookingDto = new BookingDto(
            'Alex',
            '+79021869474'
        );
    }

    public function testBookingPlace(): void
    {
        $numberOfAvailablePlaces = $this->movieShow->getNumberOfAvailablePlacesForBooking();
        $this->movieShow->bookPlace($this->bookingDto);

        $this->assertNotEquals($numberOfAvailablePlaces, $this->movieShow->getNumberOfAvailablePlacesForBooking());
    }

    public function testExceptionBookingPlace(): void
    {
        $this->movieShow->bookPlace($this->bookingDto);

        $this->expectException(DomainException::class);
        $this->movieShow->bookPlace($this->bookingDto);
    }

    public function testNumberOfAvailablePlacesForBooking(): void
    {
        $numberOfPlaces = $this->movieShow->getNumberOfAvailablePlacesForBooking();

        $this->assertIsInt($numberOfPlaces);
    }
}