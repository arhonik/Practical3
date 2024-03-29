<?php

namespace App\Tests\Unit\Collection;

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

    public function testSeeExceptionWhenTryToAddNotMovieShowObject(): void
    {
        $object = new stdClass();

        $this->expectException(DomainException::class);

        $this->movieShowCollection->add($object);
    }

    public function testProperlyAddingMovieShowObjectToCollection(): void
    {
        $movieShow = $this->createMock(MovieShow::class);

        $this->movieShowCollection->add($movieShow);

        $this->assertCount(1, $this->movieShowCollection);
        $this->assertEquals($movieShow, $this->movieShowCollection->first());
    }
}