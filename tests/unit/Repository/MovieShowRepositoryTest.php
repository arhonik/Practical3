<?php

namespace App\Tests\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieShowRepositoryTest extends WebTestCase
{
    private ?MovieShowRepository $movieShowRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieShowRepository = self::getContainer()->get(MovieShowRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->movieShowRepository = null;
    }

    public function testShouldFindAllMovieShows(): void
    {
        $movieShowCollection = $this->getMovieShowCollection();

        $this->assertCount(1, $movieShowCollection);
    }

    public function testShouldFindByIdMovieShow(): void
    {
        $movieShow = $this->getFirstMovieShow();

        $this->assertNotEmpty($movieShow);
    }

    public function testShouldSaveMovieShow(): void
    {
        $movieShow = $this->getFirstMovieShow();
        $initialNumberOfFreePlaces = $movieShow->getNumberOfAvailablePlacesForBooking();

        $bookingDto = new BookingDto(
            'Alex',
            '+79021869474'
        );

        $movieShow->bookPlace($bookingDto);
        $this->movieShowRepository->save($movieShow);

        self::assertNotEquals(
            $initialNumberOfFreePlaces,
            $movieShow->getNumberOfAvailablePlacesForBooking()
        );
    }

    private function getMovieShowCollection(): MovieShowCollection
    {
        return $this->movieShowRepository->findAll();
    }

    private function getFirstMovieShow(): MovieShow
    {
        $movieShowCollection = $this->getMovieShowCollection();

        $movieShow = $movieShowCollection->get(0);
        $movieShowId = $movieShow->getId();

        return $this->movieShowRepository->findById($movieShowId);
    }
}