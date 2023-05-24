<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\DeckInterface;
use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\HandleInput;
use SoftwareDesign\CardFramework\HumanPlayer;
use SoftwareDesign\CardFramework\AiPlayer;

abstract class CardGameTemplate implements CardGameInterface
{
    /**
     * The deck of this turn.
     *
     * @var DeckInterface
     */
    protected DeckInterface $deck;

    /**
     * The game turn.
     *
     * @var integer
     */
    protected int $turn = 0;

    /**
     * The winner of this turn.
     *
     * @var Player
     */
    protected Player $winner;

    /**
     * The engagement player list.
     * Sequentially express the order of each player.
     *
     * @var array<Player>
     */
    protected array $playerList = [];

    /**
     * Set and start up the game process.
     */
    public function __construct()
    {
        $this->setDeck()
            ->setPlayer()
            ->shuffle()
            ->drawCard()
            ->turnStart()
            ->getWinner();
    }

    /**
     * Set player.
     *
     * @return Showdown
     */
    public function setPlayer(): CardGameInterface
    {
        $playerAmount = 0;

        while ($playerAmount < 4) {

            print_r("請輸入玩家 " . $playerAmount + 1 . " 是否為機器人: (是 或 否) ");

            $isAi = HandleInput::getInput();
            $isAi = trim($isAi);

            if ($isAi === '否') {
                array_push($this->playerList, new HumanPlayer());

                $this->setName($playerAmount);
            } elseif ($isAi === '是') {
                array_push($this->playerList, new AiPlayer());

                $this->setName($playerAmount);
            } else {
                // throw Exception.
            }

            $playerAmount += 1;
        }

        return $this;
    }

    /**
     * Set player name.
     *
     * @param int $playerIndex
     * @param string $name
     * @return Showdown
     */
    public function setName(int $playerIndex): CardGameInterface
    {
        print_r("請輸入玩家 " . $playerIndex + 1 . " 名稱: ");

        $playerName = HandleInput::getInput();

        $this->playerList[$playerIndex]->setName($playerName);

        return $this;
    }

    /**
     * Shuffle the cards of Deck.
     *
     * @return Showdown
     */
    public function shuffle(): CardGameInterface
    {
        $this->deck->shuffle();

        return $this;
    }

    /**
     * 斗露
     *
     * @return Showdown
     */
    public function drawCard(): CardGameInterface
    {
        $cardAmount  = count($this->deck->getDeck());
        $playerIndex = 0;

        print_r("是否需要全部玩家自動抽牌? (範例: 是 或 否) : ");
        $isAutoDraw = HandleInput::getInput();

        while ($this->IsOverDrawCardAmount($cardAmount)) {
            if ($cardAmount !== count($this->deck->getDeck())) {
                // throw Exception;
                exit;
            }

            $player = $this->playerList[$playerIndex];

            if ($isAutoDraw === '是') {
                $drawIndex = random_int(1, $cardAmount);
            } elseif ($isAutoDraw === '否') {
                if ($player instanceof AiPlayer) {
                    $drawIndex = random_int(1, $cardAmount);
                } else {
                    print_r("{$player->getName()} 你好, 目前牌數 {$cardAmount} , 請問要抽牌堆中的第幾張呢? (範例: 1) : ");
                    $drawIndex = HandleInput::getInput();
                }
            } else {
                // throw Exception.
                exit;
            }

            if ($drawIndex > $cardAmount) {
                // throw Exception.
                print_r("輸入牌數比目前牌數多" . PHP_EOL);
                exit;
            } elseif ($drawIndex <= 0) {
                // throw Exception.
                print_r("輸入牌數必須大於 0" . PHP_EOL);
                exit;
            }

            $player->setHands(
                $this->deck->drawCard($drawIndex - 1)
            );

            if ($playerIndex === count($this->playerList) - 1) {
                $playerIndex = 0;
            } else {
                $playerIndex += 1;
            }

            $cardAmount -= 1;
        }
        return $this;
    }

    /**
     * Game Start.
     *
     * @return CardGameInterface
     */
    public function turnStart(): CardGameInterface
    {
        $this->winner = $this->playerList[0];

        while ($this->IsGameTurnOver()) {

            // Players show the card.
            $this->eachPlayerShow();
        }

        return $this;
    }

    /**
     * Get the game winner.
     *
     * @return Player
     */
    abstract public function getWinner(): Player;

    /**
     * Overrided by sub class.
     *
     * @param integer $cardAmount
     * @return boolean
     */
    abstract protected function IsOverDrawCardAmount(int $cardAmount): bool;

    /**
     * Check the card amount.
     *
     * @param integer $cardAmount
     * @return boolean
     */
    abstract protected function IsGameTurnOver(): bool;

    /**
     * Action of each player show the card.
     *
     * @return void
     */
    abstract protected function eachPlayerShow(): void;
}
