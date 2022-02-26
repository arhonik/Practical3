<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class BookingHandler implements \Symfony\Component\Messenger\Handler\MessageHandlerInterface
{
    private MovieShowRepository $movieShowRepository;
    private ManagerRegistry $doctrine;

    public function __construct(MovieShowRepository $movieShowRepository, ManagerRegistry $doctrine)
    {
        $this->movieShowRepository = $movieShowRepository;
        $this->doctrine = $doctrine;
    }

    public function __invoke(
        BookingCommand $bookingCommand
    ) {
        $movieShowUuid = Uuid::fromString($bookingCommand->movieShow);
        $movieShow = $this->movieShowRepository->findByUuid($movieShowUuid);

        $bookingDto = new BookingDto(
            $bookingCommand->name,
            $bookingCommand->phone,
            $bookingCommand->movieShow
        );
        $movieShow->bookPlace($bookingDto);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($movieShow);
        $entityManager->flush();
    }
}