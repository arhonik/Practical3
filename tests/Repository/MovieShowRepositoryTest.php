<?php

namespace App\Tests\Repository;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;

class MovieShowRepositoryTest extends WebTestCase
{
    protected ?MovieShowRepository $movieShowRepository;

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

    public function testFindAll(): void
    {
        $movieShowCollection = $this->getMovieShowCollection();

        $this->assertCount(1, $movieShowCollection);
    }

    public function testFindById(): void
    {
        $movieShow = $this->getFirstMovieShow();

        $this->assertNotEmpty($movieShow);
    }

    public function testSave(): void
    {
        $movieShow = $this->getFirstMovieShow();
        $numberOfFreePlaces = $movieShow->getNumberOfAvailablePlacesForBooking();

        $bookingDto = new BookingDto(
            'Alex',
            '+79021869474'
        );
        $movieShow->bookPlace($bookingDto);
        $this->movieShowRepository->save($movieShow);

        $movieShowExpect = $this->getFirstMovieShow();;
        self::assertNotEquals(
            $numberOfFreePlaces,
            $movieShowExpect->getNumberOfAvailablePlacesForBooking()
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