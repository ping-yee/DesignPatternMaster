<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class MatchMakingSystem
{
    /**
     * The individual list.
     *
     * @var array
     */
    protected $individualList = [];

    /**
     * The habit list can be selected by user.
     *
     * @var array
     */
    protected $habitList = [];

    public function __construct()
    {
        $this->setHabitList([
            '打籃球', '煮菜', '玩遊戲', '睡覺', '寫程式', '彈鋼琴', '閱讀',
        ])->setIndividualList([
            new Individual(1, 'MALE', 19, 'Hi', [0, 1], ['x' => 10, 'y' => 10]),
            new Individual(2, 'FEMALE', 20, 'Hello', [0, 1, 2, 3], ['x' => 20, 'y' => 20]),
            new Individual(3, 'MALE', 25, 'Hello', [2, 3, 4, 5], ['x' => 30, 'y' => 30]),
            new Individual(4, 'FEMALE', 30, 'Hello', [4, 5, 6], ['x' => 40, 'y' => 40]),
        ]);
    }

    /**
     * Setter of individualList.
     */
    public function setIndividualList(array $individualList): MatchMakingSystem
    {
        foreach ($individualList as $individual) {
            $this->individualList[$individual->getId()] = $individual;
        }

        return $this;
    }

    /**
     * Individual list getter.
     *
     * @return array $IndividualList
     */
    public function getIndividualList(): array
    {
        return $this->individualList;
    }

    /**
     * Habit list getter.
     *
     * @return array $habitList
     */
    public function getHabitList(): array
    {
        return $this->habitList;
    }

    /**
     * Setter habit list.
     */
    public function setHabitList(array $habitList): MatchMakingSystem
    {
        foreach ($habitList as $habit) {
            $this->habitList[] = $habit;
        }

        return $this;
    }

    /**
     * Pair between two user.
     */
    public function makePair(Individual $pairPerson, PairStrategyInterface $pairStrategy): bool
    {
        $pairedArray = $pairStrategy->pair($pairPerson, $this->individualList);

        $pairPerson->setMostSuitable($pairedArray[0]);

        return null !== $pairPerson->getMostSuitable();
    }
}
