<?php

namespace App\Tests\Unit\Entity;

use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Entity\TransferObject\MovieShowInfoDto;
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
    private Movie $movie;
    private Schedule $schedule;
    private MovieShow $movieShow;
    private BookingDto $bookingDto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movie = new Movie(
            'Venom 2',
            DateInterval::createFromDateString('1 hour 25 minutes')
        );

        $this->schedule = new Schedule(
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
        );

        $this->movieShow = new MovieShow(
            Uuid::v4(),
            $this->movie,
            $this->schedule,
            new Hall(
                1
            )
        );

        $this->bookingDto = new BookingDto(
            'Alex',
            '+79021869474'
        );
    }

    public function testSeeExceptionWhenAddedTicketInFullHall(): void
    {
        $this->movieShow->bookPlace($this->bookingDto);

        $this->expectException(DomainException::class);
        $this->movieShow->bookPlace($this->bookingDto);
    }

    public function testValueMovieShowInfoShouldMatchOriginal(): void
    {
        $movieShowInfo = $this->movieShow->getMovieShowInfo();

        $this->assertValueMovieShowInfoShouldMatchOriginal($movieShowInfo);
    }

    public function testUponSuccessfulBookingNumberOfAvailablePlacesShouldDecrease(): void
    {
        $initialNumberOfAvailablePlaces = $this->movieShow->getNumberOfAvailablePlacesForBooking();

        $this->movieShow->bookPlace($this->bookingDto);

        $this->assertEquals($initialNumberOfAvailablePlaces - 1, $this->movieShow->getNumberOfAvailablePlacesForBooking());
    }

    private function assertValueMovieShowInfoShouldMatchOriginal(MovieShowInfoDto $movieShowInfo): void
    {
        $this->assertEquals($movieShowInfo->getMovieTitle(), $this->movie->getTitle());
        $this->assertEquals($movieShowInfo->getMovieDuration(), $this->movie->getDuration());
        $this->assertEquals($movieShowInfo->getScheduleStartAt(), $this->schedule->getStartAt());
        $this->assertEquals($movieShowInfo->getScheduleEndAt(), $this->schedule->getEndAt());
        $this->assertEquals($movieShowInfo->getFreePlace(), $this->movieShow->getNumberOfAvailablePlacesForBooking());
    }
}