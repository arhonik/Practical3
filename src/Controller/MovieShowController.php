<?php

namespace App\Controller;

use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Form\BookingType;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Component\Routing\Annotation\Route;

class MovieShowController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', 'booking')]
    public function index(MovieShowRepository $movieShowRepository): \Symfony\Component\HttpFoundation\Response
    {
        $allMovieShow = $movieShowRepository->findAll();
        foreach ($allMovieShow->getIterator() as $index => $item) {
            $bookingDto = new BookingDto();
            $bookingDto->movieShow = $item->getId();
            $bookingForm = $this->createForm(BookingType::class, $bookingDto)->createView();
            $item->setBookingForm($bookingForm);
        }
        
        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }
}