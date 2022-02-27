<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

class BookingHandler implements MessageHandlerInterface
{
    private MovieShowRepository $movieShowRepository;

    public function __construct(MovieShowRepository $movieShowRepository)
    {
        $this->movieShowRepository = $movieShowRepository;
    }

    public function __invoke(BookingCommand $bookingCommand): void
    {
        $movieShowUuid = Uuid::fromString($bookingCommand->movieShow);
        $movieShow = $this->movieShowRepository->findByUuid($movieShowUuid);

        $bookingDto = new BookingDto(
            $bookingCommand->name,
            $bookingCommand->phone,
        );
        $movieShow->bookPlace($bookingDto);

        $this->movieShowRepository->save($movieShow);
    }
}