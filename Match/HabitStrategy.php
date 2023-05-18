<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class HabitStrategy implements PairStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function pair(Individual $pairPerson, array $individualList): array
    {
        $pairPersonHabit = $pairPerson->getHabit();

        $habitAmountArr = [];

        foreach ($individualList as $key => $individual) {
            $individualHabit = $individual->getHabit();

            $habitAmountArr[] = count(array_intersect($pairPersonHabit, $individualHabit));
        }

        array_multisort($habitAmountArr, SORT_DESC, $individualList);

        return $individualList;
    }
}
