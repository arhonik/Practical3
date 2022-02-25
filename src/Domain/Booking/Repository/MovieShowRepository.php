<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\UuidV4;

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
                )
            );
        }

        return $moVieShowCollection;
    }

    public function findByUuid(string $id): MovieShow
    {
        $entityManager = $this->getEntityManager();
        $uuid = UuidV4::fromString($id);
        $queryMovieShow = $entityManager
            ->createQuery(
                "SELECT 
                    ms
                FROM 
                    App\Domain\Booking\Entity\MovieShow ms
                WHERE ms.id = '". $uuid->toRfc4122() . "'"
            );
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select("ms")
            ->from("App\Domain\Booking\Entity\MovieShow", "ms")
            ->where("ms.id = ?1")
            ->setParameter(1, $uuid->toBinary());

        $movieShow = $queryBuilder->getQuery();
        $result = $movieShow->getArrayResult();

        return new MovieShow(
            $result[0]["id"],
            new Movie(
                $result[0]["movie.title"],
                $result[0]["movie.duration"],
            ),
            new Schedule(
                $result[0]["schedule.startAt"],
                $result[0]["schedule.endAt"],
            ),
            new Hall(
                $result[0]["hall.numberOfPlaces"]
            ),
        );
    }




}