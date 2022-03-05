<?php

namespace App\Tests\Unit\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class BookingHandlerTest extends WebTestCase
{
    private ?MessageBusInterface $bus;
    private ?MovieShowRepository $movieShowRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = self::getContainer()->get(MessageBusInterface::class);

        $this->movieShowRepository = self::getContainer()->get(MovieShowRepository::class);
    }

    public function testCommandShouldExecutCorrectly(): void
    {
        $movieShow = $this->getFirstMovieShow();
        $numberOfFreePlaces = $movieShow->getNumberOfAvailablePlacesForBooking();
        $command = $this->getCommand($movieShow->getId());

        $this->bus->dispatch($command);

        self::assertNotEquals(
            $numberOfFreePlaces,
            $movieShow->getNumberOfAvailablePlacesForBooking()
        );
    }

    private function getFirstMovieShow(): MovieShow
    {
        $movieShowCollection = $this->movieShowRepository->findAll();

        $movieShow = $movieShowCollection->first();
        $movieShowId = $movieShow->getId();

        return $this->movieShowRepository->findById($movieShowId);
    }

    private function getCommand(Uuid $movieShowId): BookTicketCommand
    {
        $command = new BookTicketCommand();
        $command->phone = '+79021869474';
        $command->name = 'Alex';
        $command->movieShowId = $movieShowId->toRfc4122();

        return $command;
    }
}