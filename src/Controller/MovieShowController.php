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
    #[Route(path: '/', name: 'booking')]
    public function index(
        MovieShowRepository $movieShowRepository,
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $allMovieShow = $movieShowRepository->findAll();
        foreach ($allMovieShow as $movieShow) {
            $bookingForm = $this->createBookingForm($movieShow->getId());
            $bookingFormView = $bookingForm->createView();
            $movieShow->setBookingForm($bookingFormView);

            $bookingForm->handleRequest($request);
            if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
                $data = $bookingForm->getData();

                if ($this->isCorrectCommand($data, $movieShow)) {
                    $bus->dispatch($data);
                }
            }
        }

        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
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