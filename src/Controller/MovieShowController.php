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
        foreach ($allMovieShow->getIterator() as $item) {
            $bookingForm = $this->createBookingForm($item->getId());
            $bookingFormView = $bookingForm->createView();
            $item->setBookingForm($bookingFormView);

            $bookingForm->handleRequest($request);
            if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
                $data = $bookingForm->getData();

                if ($this->isTrueFrom($data, $item)) {
                    $bus->dispatch($data);
                }
            }
        }

        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }

    private function createBookingForm(Uuid $id): FormInterface
    {
        $bookingCommand = new BookingCommand();
        $bookingCommand->movieShow = $id;
        
        return $this->createForm(BookingType::class, $bookingCommand);
    }

    private function isTrueFrom(BookingCommand $command, MovieShow $movieShow): bool
    {
        return $command->movieShow == $movieShow->getId();
    }
}