<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\MovieShow;
use Doctrine\Common\Collections\ArrayCollection;
use DomainException;

class MovieShowCollection extends ArrayCollection
{
    public function add(mixed $movieShow): void
    {
        self::assertShouldBeMovieShow($movieShow);
        parent::add($movieShow);
    }

    public static function assertShouldBeMovieShow(mixed $movieShow): void
    {
        if (!$movieShow instanceof MovieShow) {
            throw new DomainException('Invalid object');
        }
    }
}