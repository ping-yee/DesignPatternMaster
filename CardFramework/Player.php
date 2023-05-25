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

    public function showNowCards()
    {
        foreach ($this->getHands() as $key => $card) {
            $cardIndex = $key + 1;
            print_r("第 {$cardIndex} 張為： {$card->__get("rank")} {$card->__get("suit")}" . PHP_EOL);
        }
        print_r(PHP_EOL);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
