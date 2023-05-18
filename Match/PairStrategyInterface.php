<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

interface PairStrategyInterface
{
    /**
     * The pair feature with different strategy.
     */
    public function pair(Individual $pairPerson, array $individualList): array;
}
