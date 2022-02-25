<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
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

        $arrayMovieShow = $queryMovieShow->getResult();
        $moVieShowCollection = new MovieShowCollection($arrayMovieShow);

        return $moVieShowCollection;
    }

    public function findByUuid(UuidV4 $id): MovieShow
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select("ms")
            ->from("App\Domain\Booking\Entity\MovieShow", "ms")
            ->where("ms.id = ?1")
            ->setParameter(1, $id->toBinary());

        $movieShow = $queryBuilder->getQuery();
        $result = $movieShow->getSingleResult();

        return $result;
    }




}