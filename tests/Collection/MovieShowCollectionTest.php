<?php

namespace App\Tests\Collection;

use App\Domain\Booking\Collection\MovieShowCollection;
use App\Domain\Booking\Entity\MovieShow;
use DomainException;
use Monolog\Test\TestCase;
use stdClass;

class MovieShowCollectionTest extends TestCase
{
    private MovieShowCollection $movieShowCollection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieShowCollection = new MovieShowCollection();
    }

    public function testExceptionAddMovieShow(): void
    {
        $object = new stdClass();

        $this->expectException(DomainException::class);

        $this->movieShowCollection->add($object);
    }

    public function testCorrectAddMovieShow(): void
    {
        $this->movieShowCollection->add($this->getMovieShow());

        $this->assertCount(1, $this->movieShowCollection);
    }

    private function getMovieShow(): MovieShow
    {
        return $this->createMock(MovieShow::class);
    }
}