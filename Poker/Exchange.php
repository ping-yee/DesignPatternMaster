<?php

namespace SoftwareDesign\Poker;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\Poker\Card;

class Exchange
{
    /**
     * Record the exchaged turn.
     *
     * @var integer
     */
    protected int $turn = 0;

    /**
     * The player is asked to exchange the card.
     *
     * @var Player
     */
    protected Player $exchagePlayer;

    /**
     * The player is asked to exchange the card.
     *
     * @var Player
     */
    protected Player $exchagedPlayer;

    /**
     * The player1 exchanging card.
     * If value is null means the exchanged card has been show by player.
     *
     * @var Card
     */
    protected Card $player1Card;

    /**
     * The player2 exchanging card.
     * If value is null means the exchanged card has been show by player.
     *
     * @var Card
     */
    protected Card $player2Card;

    public function __construct(
        Player $exchagePlayer,
        int $player1CardIndex,
        Player $exchagedPlayer,
        int $player2CardIndex
    ) {
        $this->exchagePlayer      = $exchagePlayer;
        $this->player1Card        = $exchagePlayer->getHands()[$player1CardIndex];
        $this->exchagedPlayer     = $exchagedPlayer;
        $this->player2Card        = $exchagedPlayer->getHands()[$player2CardIndex];

        $this->exchagePlayer->setHandByIndex($player1CardIndex, $this->player2Card);
        $this->exchagedPlayer->setHandByIndex($player2CardIndex, $this->player1Card);

        print_r("交換成功" . PHP_EOL);
    }

    /**
     * Check turn.
     *
     * @return boolean
     */
    public function checkTurn(): bool
    {
        if ($this->turn === 3) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Add turn.
     *
     * @return void
     */
    public function addTurn(): void
    {
        $this->turn += 1;
    }

    /**
     * Change the card back.
     *
     * @return void
     */
    public function changeBack()
    {
        $player1CardIndex = array_search($this->player1Card, $this->exchagedPlayer->getHands());
        $player2CardIndex = array_search($this->player2Card, $this->exchagePlayer->getHands());

        if ($player1CardIndex === false || $player2CardIndex === false) {
            print_r("你或對方已經將換的牌出掉" . PHP_EOL);
        } else {
            $this->exchagePlayer->getHands()[$player1CardIndex]  = $this->player1Card;
            $this->exchagedPlayer->getHands()[$player2CardIndex] = $this->player2Card;

            print_r("交換時間已到, 已將手牌交換回來" . PHP_EOL);
        }
    }

    public function __get($name)
    {
        return $this->{$name};
    }
}
