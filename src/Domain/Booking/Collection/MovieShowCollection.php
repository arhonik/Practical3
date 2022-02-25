<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\MovieShow;
use Doctrine\Common\Collections\ArrayCollection;

class MovieShowCollection extends ArrayCollection
{
    public function add(mixed $ticket): void
    {
        self::assertShouldBeMovieShow($ticket);
        parent::add($ticket);
    }

    public static function assertShouldBeMovieShow(mixed $movieShow): void
    {
        if (!$movieShow instanceof MovieShow) {
            throw new \DomainException('Invalid object');
        }
    }
}