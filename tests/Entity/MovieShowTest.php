<?php

namespace App\Tests\Entity;

use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use Symfony\Component\Uid\Uuid;

class MovieShowTest extends \Monolog\Test\TestCase
{
    protected MovieShow $movieShow;

    public function setUp(): void
    {
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

    public function testBookingPlace(): void
    {
        $bookingDto = new BookingDto(
            'Alex',
            '+7902186974'
        );

        $numberOfAvailablePlacesBeforeBooking = $this->movieShow->getNumberOfAvailablePlacesForBooking();
        $this->movieShow->bookPlace($bookingDto);
        $numberOfAvailablePlacesAfterBooking = $this->movieShow->getNumberOfAvailablePlacesForBooking();

        $this->assertEquals($numberOfAvailablePlacesBeforeBooking - 1, $numberOfAvailablePlacesAfterBooking);
    }
}