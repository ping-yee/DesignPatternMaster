<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class Individual
{
    /**
     * User ID.
     */
    protected int $id = 0;

    /**
     * User gender.
     */
    protected string $gender = 'Male';

    /**
     * User age.
     */
    protected int $age = 0;

    /**
     * User intro.
     */
    protected ?string $intro = null;

    /**
     * There are habit collection will let user choose to put in.
     */
    protected array $habit = [];

    /**
     * The user coord.
     * The format will following:
     * [x => 100, y => 100]
     *
     * @var array<string,int>
     */
    protected array $coord = [];

    /**
     * Paired by match making system.
     */
    protected ?Individual $mostSuitable = null;

    public function __construct(
        int $id,
        string $gender,
        int $age,
        ?string $intro,
        array $habit,
        array $coord
    ) {
        $this->id     = $id;
        $this->gender = $gender;
        $this->age    = $age;
        $this->intro  = $intro;
        $this->habit  = $habit;
        $this->coord  = $coord;
    }

    /**
     * Habit getter.
     */
    public function getHabit(): array
    {
        return $this->habit;
    }

    /**
     * Coord getter.
     */
    public function getCoord(): array
    {
        return $this->coord;
    }

    /**
     * Name getter.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * MostSuitable getter.
     *
     * @return Individual|null $mostSuitable
     */
    public function getMostSuitable(): ?Individual
    {
        return $this->mostSuitable;
    }

    /**
     * Set by match making system.
     *
     * @return void
     */
    public function setMostSuitable(Individual $mostSuitable)
    {
        $this->mostSuitable = $mostSuitable;
    }
}
