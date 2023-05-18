<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class Reverse implements PairStrategyInterface
{
    /**
     * The strategy the reverse used.
     */
    protected ?PairStrategyInterface $strategy = null;

    public function __construct(PairStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * {@inheritDoc}
     */
    public function pair(Individual $pairPerson, array $individualList): array
    {
        return array_reverse($this->strategy->pair($pairPerson, $individualList));
    }
}
