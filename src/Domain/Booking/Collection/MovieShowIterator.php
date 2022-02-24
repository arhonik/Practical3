<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\MovieShow;
use Iterator;

class MovieShowIterator implements Iterator
{
    private MovieShowCollection $collection;
    private int $position = 0;
    private bool $reverse;

    public function __construct(MovieShowCollection $collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind()
    {
        $this->position = $this->reverse ?
            count($this->collection->get()) - 1 : 0;
    }

    public function current(): MovieShow
    {
        return $this->collection->get()[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next()
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function valid(): bool
    {
        return isset($this->collection->get()[$this->position]);
    }

}