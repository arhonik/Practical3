<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Collection\TicketsCollection;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\MovieShowInfo;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use Doctrine\Common\Collections\Collection;
use DomainException;
use Iterator;
use Symfony\Component\Form\FormView;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class MovieShow
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Embedded(class: Movie::class)]
    private Movie $movie;

    #[ORM\Embedded(class: Schedule::class)]
    private Schedule $schedule;

    #[ORM\Embedded(class: Hall::class)]
    private Hall $hall;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'movieShow', cascade: ['persist'])]
    private Collection $ticketsCollection;

    private FormView $bookingForm;

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

    public function bookPlace(BookingDto $client): void
    {
        self::assertCanBeAddTicket($this->getTicketsCollection(), $this->hall->getNumberOfPlaces());
        $ticket = new Ticket(
            Uuid::v4(),
            $this,
            new Customer(
                $client->name,
                $client->phone,
            ),
            $this->movie->getTitle(),
            $this->schedule->getStartAt(),
        );
        $this->ticketsCollection->add($ticket);
    }

    private static function assertCanBeAddTicket(Collection $ticketsCollection, int $numberOfPlaces): void
    {
        if (!self::checkIfFreePlaces($ticketsCollection, $numberOfPlaces)) {
            throw new DomainException('No free places');
        }
    }

    private static function checkIfFreePlaces(Collection $ticketsCollection, int $numberOfPlaces): bool
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

    private function getTicketsCollection(): Collection
    {
        return $this->ticketsCollection;
    }

    public function getTicketsCollectionIterator(): Iterator
    {
        return $this->ticketsCollection->getIterator();
    }

    public function getBookingForm(): FormView
    {
        return $this->bookingForm;
    }

    public function setBookingForm(FormView $bookingForm): void
    {
        $this->bookingForm = $bookingForm;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}