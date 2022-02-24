<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovieShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieShow::class);
    }
    public function findAll(): MovieShowCollection
    {
        $entityManager = $this->getEntityManager();
        $queryMovieShow = $entityManager
            ->createQuery(
                "SELECT 
                    ms
                FROM 
                    App\Domain\Booking\Entity\MovieShow ms"
            );

        $arrayMovieShow = $queryMovieShow->getArrayResult();
        $moVieShowCollection = new MovieShowCollection();
        foreach ($arrayMovieShow as $index => $item) {
            $moVieShowCollection->add(
                new MovieShow(
                    $item["id"],
                    new Movie(
                        $item["movie.title"],
                        $item["movie.duration"],
                    ),
                    new Schedule(
                        $item["schedule.startAt"],
                        $item["schedule.endAt"],
                    ),
                    new Hall(
                        $item["hall.numberOfPlaces"]
                    ),
                ),
            );
        }

        return $moVieShowCollection;
    }
}