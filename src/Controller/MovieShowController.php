<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookingCommand;
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
    public function movieShow(): Response
    {
        $allMovieShow = $this->movieShowRepository->findAll();
        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }

    #[Route(path: '/booking/{movieShowId}', name: 'booking')]
    public function booking(
        string $movieShowId,
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $movieShow = $this->movieShowRepository->findByUuid(Uuid::fromString($movieShowId));
        $bookingForm = $this->createBookingForm($movieShow->getId());

        $bookingForm->handleRequest($request);
        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $bus->dispatch($bookingForm->getData());
            $this->addFlash("notice","Your request has been accepted. The data is being processed.");

            return $this->redirectToRoute("movie-shows");
        }

        return $this->render("booking.html.twig", ["movieShow" => $movieShow, "form" => $bookingForm->createView()]);
    }

    private function createBookingForm(Uuid $id): FormInterface
    {
        $bookingCommand = new BookingCommand();
        $bookingCommand->movieShowId = $id;
        
        return $this->createForm(BookingType::class, $bookingCommand);
    }
}