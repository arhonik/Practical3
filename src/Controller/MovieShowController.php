<?php

namespace App\Controller;

use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Form\BookingType;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class MovieShowController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route(path: '/', name: 'booking')]
    public function index(
        MovieShowRepository $movieShowRepository,
        Request $request,
        MessageBusInterface $bus
    ): \Symfony\Component\HttpFoundation\Response {
        $allMovieShow = $movieShowRepository->findAll();
        foreach ($allMovieShow->getIterator() as $index => $item) {
            $bookingDto = new BookingDto();
            $bookingDto->movieShow = $item->getId();
            $bookingForm = $this->createForm(BookingType::class, $bookingDto);
            $bookingFormView = $bookingForm->createView();
            $item->setBookingForm($bookingFormView);
            $bookingForm->handleRequest($request);
            if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
                $data = $bookingForm->getData();
                if ($data->movieShow == $item->getId()) {
                    $bus->dispatch($data);
                }
            }
        }

        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }
}