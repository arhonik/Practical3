<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Customer;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid as Uuid;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: MovieShow::class, inversedBy: 'ticketsCollection')]
    #[ORM\JoinColumn(name: 'movie_show_id', referencedColumnName: 'id')]
    private MovieShow $movieShow;

    #[ORM\Embedded(class: Customer::class)]
    private Customer $customer;

    #[ORM\Column(type: 'string')]
    private string $movie;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $startTime;

    public function __construct(
        Uuid $id,
        MovieShow $movieShow,
        Customer $customer,
        string $movie,
        DateTimeInterface $startTime
    ) {
        $this->id = $id;
        $this->movieShow = $movieShow;
        $this->customer = $customer;
        $this->movie = $movie;
        $this->startTime = $startTime;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getMovieShow(): MovieShow
    {
        return $this->movieShow;
    }

    public function getCustomerName(): string
    {
        return $this->customer->getName();
    }

    public function getCustomerPhone(): string
    {
        return $this->customer->getPhone();
    }

    public function getMovie(): string
    {
        return $this->movie;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
    }
}