<?php

namespace SoftwareDesign\Poker;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\Poker\PlayerInterface;

abstract class Player implements PlayerInterface
{
    /**
     * The player name.
     *
     * @var string
     */
    protected string $name;

    /**
     * Show whether the player already exchanged the card.
     *
     * @var boolean
     */
    protected bool $isExchanged = false;

    /**
     * The player's score.
     *
     * @var integer
     */
    protected int $score = 0;

    /**
     * The player's hands.
     *
     * @var array<Card>
     */
    protected array $hands = [];

    /**
     * The exchange instance, will be created by player use exchange right.
     *
     * @var Exchange|null
     */
    protected ?Exchange $exchange = null;

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
    public function setHands(Card $card): PlayerInterface
    {
        if (count($this->hands) < 13) {
            array_push($this->hands, $card);
        } else {
            // throw exception.
            exit;
        }

        return $this;
    }

    public function setHandByIndex(int $handsIndex, Card $card)
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

    public function getIsExchanged(): bool
    {
        return $this->isExchanged;
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

    /**
     * {@inheritDoc}
     */
    abstract public function exchange(Player $player): PlayerInterface;
}
