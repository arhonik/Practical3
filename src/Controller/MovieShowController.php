<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Form\BookingType;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class MovieShowController extends AbstractController
{
    private MovieShowRepository $movieShowRepository;
    public function __construct(MovieShowRepository $movieShowRepository,)
    {
        $this->movieShowRepository = $movieShowRepository;
    }

    #[Route(path: '/movie-shows', name: 'movie-shows')]
    public function movieShow(
    ): Response {
        $allMovieShow = $this->movieShowRepository->findAll();
        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }

    #[Route(path: '/booking/{movieShowId}', name: 'booking')]
    public function booking(
        string $movieShowId,
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $movieShowUuid = Uuid::fromString($movieShowId);
        $movieShow = $this->movieShowRepository->findByUuid($movieShowUuid);

        $bookingForm = $this->createBookingForm($movieShow->getId());
        $bookingFormView = $bookingForm->createView();

        $bookingForm->handleRequest($request);
        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $bus->dispatch($bookingForm->getData());

            $this->addFlash(
                "notice",
                "Ticket create."
            );
        }

        return $this->render("booking.html.twig", ["movieShow" => $movieShow, "form" => $bookingFormView]);
    }

    private function createBookingForm(Uuid $id): FormInterface
    {
        $bookingCommand = new BookingCommand();
        $bookingCommand->movieShowId = $id;
        
        return $this->createForm(BookingType::class, $bookingCommand);
    }

    private function isCorrectCommand(BookingCommand $command, MovieShow $movieShow): bool
    {
        return $command->movieShowId == $movieShow->getId();
    }
}