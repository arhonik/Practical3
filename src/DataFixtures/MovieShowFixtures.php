<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\ValueObject\Hall;
use App\Domain\Booking\Entity\ValueObject\Movie;
use App\Domain\Booking\Entity\ValueObject\Schedule;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class MovieShowFixtures extends Fixture
{
    private MovieShowRepository $movieShowRepository;

    public function __construct(MovieShowRepository $movieShowRepository)
    {
        $this->movieShowRepository = $movieShowRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->movieShowRepository->save(new MovieShow(
            Uuid::v4(),
            new Movie(
                'Venom 2',
                \DateInterval::createFromDateString('1 hour 25 minutes')
            ),
            new Schedule(
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 19:45',
                    new \DateTimeZone('Europe/Moscow')
                ),
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i',
                    '2022-10-11 21:10',
                    new \DateTimeZone('Europe/Moscow')
                ),
            ),
            new Hall(
                100
            )
        ));
    }
}
