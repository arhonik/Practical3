<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Uid\Uuid;

class TicketFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;

    public const TICKET_REFERENCE = 'ticket';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $movieShow = $this->getReference(MovieShowFixtures::MOVIE_SHOW_REFERENCE);
        assert($movieShow instanceof MovieShow);

        $ticket = new Ticket(
            Uuid::v4(),
            $movieShow,
            new Customer(
              'Alex',
              '+79271234567'
            ),
            $movieShow->getMovieShowInfo()->getMovieTitle(),
            $movieShow->getMovieShowInfo()->getScheduleStartAt()
        );

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        $this->addReference(self::TICKET_REFERENCE, $ticket);
    }
}