<?php

namespace App\Domain\Booking\Handler;

use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\Persistence\ManagerRegistry;

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
        BookingDto $bookingDto
    ) {
        $movieShow = $this->movieShowRepository->findByUuid($bookingDto->movieShow);
        $ticket = $movieShow->bookPlace($bookingDto);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($ticket);
        $entityManager->flush();
    }
}