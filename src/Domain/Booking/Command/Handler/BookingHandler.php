<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
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
        $movieShow = $this->movieShowRepository->findById(Uuid::fromString($bookingCommand->movieShowId));

        $bookingDto = new BookingDto(
            $bookingCommand->name,
            $bookingCommand->phone,
        );
        $movieShow->bookPlace($bookingDto);

        $this->movieShowRepository->save($movieShow);
    }
}