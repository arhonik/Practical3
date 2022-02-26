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
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select("ms")
            ->from("App\Domain\Booking\Entity\MovieShow", "ms");
        $queryMovieShow = $queryBuilder->getQuery();
        $movieShow = $queryMovieShow->getResult();

        return new MovieShowCollection($movieShow);
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

        $queryMovieShow = $queryBuilder->getQuery();
        return $queryMovieShow->getSingleResult();
    }




}