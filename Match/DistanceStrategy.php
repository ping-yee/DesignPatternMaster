<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class DistanceStrategy implements PairStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function pair(Individual $pairPerson, array $individualList): array
    {
        $pairPersonCoord = $pairPerson->getCoord();

        $distanceArr = [];

        foreach ($individualList as $key => $individual) {
            $individualCoord = $individual->getCoord();
            $distance        = sqrt(
                ($pairPersonCoord['y'] - $individualCoord['y']) ** 2 + ($pairPersonCoord['x'] - $individualCoord['x']) ** 2
            );

            $distanceArr[] = $distance;
        }

        array_multisort($distanceArr, $individualList);

        return $individualList;
    }
}
