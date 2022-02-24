<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Collection\TicketsCollection;
use App\Domain\Booking\Entity\TransferObject\CustomerDto;
use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\MovieShowInfo;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use DomainException;
use Iterator;
use Symfony\Component\Uid\Uuid;

class MovieShow
{
    private Uuid $id;
    private Movie $movie;
    private Schedule $schedule;
    private Hall $hall;
    private TicketsCollection $ticketsCollection;

    public function __construct(
        Uuid $id,
        Movie $movie,
        Schedule $schedule,
        Hall $hall
    ) {
        $this->id = $id;
        $this->movie = $movie;
        $this->schedule = $schedule;
        $this->hall = $hall;
        $this->ticketsCollection = new TicketsCollection();
    }

    public function bookPlace(CustomerDto $client): void
    {
        self::assertCanBeAddTicket($this->getTicketsCollection(), $this->hall->getNumberOfPlaces());

        $this->ticketsCollection->add(new Ticket(
            Uuid::v4(),
            new Customer(
                $client->name,
                $client->phone,
            ),
            $this->movie->getTitle(),
            $this->schedule->getStartAt(),
        ));
    }

    private static function assertCanBeAddTicket(TicketsCollection $ticketsCollection, int $numberOfPlaces): void
    {
        if (!self::checkIfFreePlaces($ticketsCollection, $numberOfPlaces)) {
            throw new DomainException('No free places');
        }
    }

    private static function checkIfFreePlaces(TicketsCollection $ticketsCollection, int $numberOfPlaces): bool
    {
        $freePlaces = $numberOfPlaces - $ticketsCollection->count();
        return $freePlaces > 0;
    }

    public function getMovieShowInfo(): MovieShowInfo
    {
        return new MovieShowInfo(
            $this->movie,
            $this->schedule,
            $this->getNumberOfAvailablePlacesForBooking(),
        );
    }

    public function getNumberOfAvailablePlacesForBooking(): int
    {
        return $this->hall->getNumberOfPlaces() - $this->ticketsCollection->count();
    }

    private function getTicketsCollection(): TicketsCollection
    {
        return $this->ticketsCollection;
    }

    public function getTicketsCollectionIterator(): Iterator
    {
        return $this->ticketsCollection->getIterator();
    }
}