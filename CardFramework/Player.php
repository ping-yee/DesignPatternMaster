<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\PlayerInterface;
use SoftwareDesign\CardFramework\CardTemplate;

abstract class Player implements PlayerInterface
{
    /**
     * The player name.
     *
     * @var string
     */
    protected string $name;

    /**
     * The player's score.
     *
     * @var integer
     */
    protected int $score = 0;

    /**
     * The player's hands.
     *
     * @var array<CardTemplate>
     */
    protected array $hands = [];

    /**
     * Set the card game.
     *
     * @var string
     */
    protected string $game = '';

    public function __construct(string $name = null)
    {
        if (is_null($name) === false) {
            $this->setName($name);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setName(string $name): PlayerInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setHands(CardTemplate $card): PlayerInterface
    {
        array_push($this->hands, $card);

        return $this;
    }

    public function setHandByIndex(int $handsIndex, CardTemplate $card)
    {
        $this->hands[$handsIndex] = $card;
    }

    /**
     * {@inheritDoc}
     */
    public function getHands(): array
    {
        return $this->hands;
    }

    /**
     * {@inheritDoc}
     */
    public function addPoint(): PlayerInterface
    {
        $this->score += 1;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Print the player hands.
     * It doesn't have extendability, may can be refactored.
     *
     * @return void
     */
    public function showNowCards()
    {
        foreach ($this->getHands() as $key => $card) {
            $cardIndex = $key + 1;

            if ($this->game === "Showdown") {
                print_r("第 {$cardIndex} 張為： {$card->__get("rank")} {$card->__get("suit")}" . PHP_EOL);
            } elseif ($this->game === "Uno") {
                print_r("第 {$cardIndex} 張為： {$card->__get("number")} {$card->__get("color")}" . PHP_EOL);
            }
        }
        print_r(PHP_EOL);
    }

    /**
     * Name Setter.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Game Setter.
     *
     * @param string $game
     * @return PlayerInterface
     */
    public function setGame(string $game): PlayerInterface
    {
        $this->game = $game;

        return $this;
    }
}
