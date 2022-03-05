<?php

namespace App\Tests\Functional\Command\Handler;

use App\DataFixtures\MovieShowFixtures;
use App\Domain\Booking\Command\BookTicketCommand;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class BookingHandlerTest extends WebTestCase
{
    private ?MessageBusInterface $bus;
    private ?ReferenceRepository $referenceRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = self::getContainer()->get(MessageBusInterface::class);

        $datasetTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->referenceRepository = $datasetTool->loadFixtures(
            [MovieShowFixtures::class]
        )->getReferenceRepository();

        unset($datasetTool);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->bus = null;
        $this->referenceRepository = null;
    }

    public function testCommandShouldExecuteCorrectly(): void
    {
        $movieShow = $this->referenceRepository->getReference(MovieShowFixtures::MOVIE_SHOW_REFERENCE);

        $numberOfFreePlaces = $movieShow->getNumberOfAvailablePlacesForBooking();

        $command = $this->getCommand($movieShow->getId());

        $this->bus->dispatch($command);

        self::assertEquals(
            $numberOfFreePlaces - 1,
            $movieShow->getNumberOfAvailablePlacesForBooking()
        );
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