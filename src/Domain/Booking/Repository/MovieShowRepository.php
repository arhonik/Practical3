<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class MovieShowRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieShow::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findAll(): MovieShowCollection
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('ms')
            ->from(MovieShow::class, 'ms');
        $queryMovieShow = $queryBuilder->getQuery();
        $movieShow = $queryMovieShow->getResult();

        return new MovieShowCollection($movieShow);
    }

    public function findById(Uuid $id): MovieShow
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('ms')
            ->from(MovieShow::class, 'ms')
            ->where('ms.id = :id')
            ->setParameter('id', $id->toBinary());

        $queryMovieShow = $queryBuilder->getQuery();

        return $queryMovieShow->getSingleResult();
    }

    public function save(MovieShow $movieShow): void
    {
        $this->entityManager->persist($movieShow);
        $this->entityManager->flush();
    }
}