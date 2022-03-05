<?php

namespace App\Tests\Functional\Repository;

use App\DataFixtures\MovieShowFixtures;
use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\TransferObject\BookingDto;
use App\Domain\Booking\Repository\MovieShowRepository;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieShowRepositoryTest extends WebTestCase
{
    private ?MovieShowRepository $movieShowRepository;
    private ?ReferenceRepository $referenceRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieShowRepository = self::getContainer()->get(MovieShowRepository::class);

        $databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->referenceRepository = $databaseTool->loadFixtures(
            [MovieShowFixtures::class]
        )->getReferenceRepository();

        unset($databaseTool);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->movieShowRepository = null;
        $this->referenceRepository = null;
    }

    public function testShouldFindAllMovieShows(): void
    {
        $movieShowCollection = $this->getMovieShowCollection();

        $this->assertCount(1, $movieShowCollection);
    }

    public function testShouldFindByIdMovieShow(): void
    {
        $movieShow = $this->referenceRepository->getReference(MovieShowFixtures::MOVIE_SHOW_REFERENCE);

        $movieShowExpect = $this->movieShowRepository->findById($movieShow->getId());

        $this->assertEquals($movieShow->getId(), $movieShowExpect->getId());
    }

    public function testShouldSaveMovieShow(): void
    {
        $movieShow = $this->referenceRepository->getReference(MovieShowFixtures::MOVIE_SHOW_REFERENCE);

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
}