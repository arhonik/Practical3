<?php

namespace App\Controller;

use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Component\Routing\Annotation\Route;

class MovieShowController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', 'booking')]
    public function index(MovieShowRepository $movieShowRepository): \Symfony\Component\HttpFoundation\Response
    {
        $allMovieShow = $movieShowRepository->findAll();
        return $this->render("movieshow.html.twig", ["allMovieShow" => $allMovieShow]);
    }
}