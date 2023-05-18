<?php

namespace SoftwareDesign\Poker;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\Poker\Deck;
use SoftwareDesign\Poker\Player;
use SoftwareDesign\Poker\HandleInput;
use SoftwareDesign\Poker\HumanPlayer;
use SoftwareDesign\Poker\AiPlayer;

class Showdown
{
    /**
     * The game trun.
     *
     * @var integer
     */
    protected int $turn = 0;

    /**
     * The deck of this turn.
     *
     * @var Deck
     */
    protected Deck $deck;

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
     * The setter of Deck.
     *
     * @return Showdown
     */
    public function setDeck(): Showdown
    {
        $this->deck = new Deck();
        return $this;
    }

    /**
     * Set player.
     *
     * @return Showdown
     */
    public function setPlayer(): Showdown
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
    public function setName(int $playerIndex): self
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
    public function shuffle(): Showdown
    {
        $this->deck->shuffle();

        return $this;
    }

    /**
     * 斗露
     *
     * @return Showdown
     */
    public function drawCard(): Showdown
    {
        $cardAmount  = count($this->deck->getDeck());
        $playerIndex = 0;

        print_r("是否需要全部玩家自動抽牌? (範例: 是 或 否) : ");
        $isAutoDraw = HandleInput::getInput();

        while ($cardAmount > 0) {
            if ($cardAmount !== count($this->deck->getDeck())) {
                // throw Exception;
                exit;
            }

            $player = $this->playerList[$playerIndex];

            if (count($player->getHands()) > 13) {
                // throw Exception
                exit;
            }

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
     * @return Showdown
     */
    public function turnStart(): Showdown
    {
        $this->winner = $this->playerList[0];

        while ($this->turn < 13) {
            $playerIndex = 0;

            $turnShowResult = [];

            // Player takes a turn.
            while ($playerIndex < count($this->playerList)) {
                $player = $this->playerList[$playerIndex];

                // Handle change task.
                if ($player->getIsExchanged() === false) {
                    $isExchange = $player->isExchange($player);

                    if ($isExchange === true) {
                        $exchangePlayer = $this->beforeExchange($playerIndex);
                        $player->exchange($exchangePlayer);
                    }
                }

                $playerShowCard = $player->show();

                $turnShowResult[] = [
                    "card"   => $playerShowCard,
                    "player" => $player
                ];

                $playerIndex += 1;

                print_r("------------------------------");
                print_r(PHP_EOL . "玩家 {$player->getName()} 出牌結束" . PHP_EOL);
                print_r("------------------------------" . PHP_EOL . PHP_EOL);
            }

            print_r("------------------------------" . PHP_EOL);
            print_r("第 " . ($this->turn + 1) ." 回合結算:" . PHP_EOL . PHP_EOL);


            foreach ($turnShowResult as $key => $turnShow) {
                $player = $turnShow["player"];
                $card   = $turnShow["card"];
                $cardRank = $card->__get("rank");
                $cardSuit = $card->__get("suit");

                print_r("本局玩家 {$player->getName()} 出了 {$cardRank} {$cardSuit}" . PHP_EOL);
            }

            $highestPlayer = $this->getHighestPlayer($turnShowResult);

            print_r(PHP_EOL . "由 {$highestPlayer->getName()} 獲勝並加分!" . PHP_EOL);

            $highestPlayer->addPoint();

            if ($highestPlayer->getScore() > $this->winner->getScore()) {
                $this->winner = $highestPlayer;
            }

            $this->turn += 1;

            print_r("------------------------------" . PHP_EOL . PHP_EOL);

        }
        return $this;
    }

    /**
     * Before work before exchange.
     *
     * @param integer $playerIndex
     * @return Player
     */
    public function beforeExchange(int $playerIndex): Player
    {
        print_r("你是第 " . $playerIndex + 1 . " 位玩家, 請問你要跟除了你以外的誰交換呢? (範例: 1) : ");
        $exchangePlayerIndex = HandleInput::getInput();

        if ($exchangePlayerIndex === $playerIndex) {
            // throw Exception.
        } elseif ($exchangePlayerIndex > count($this->playerList) - 1) {
            // throw Exception.
        } elseif ($exchangePlayerIndex <= 0) {
            // throw Exception.
        }

        $exchangePlayerIndex = $exchangePlayerIndex - 1;
        return $this->playerList[$exchangePlayerIndex];
    }

    public function getHighestPlayer(array $showResult): Player
    {
        return $this->playerList[$this->deck->getHighestPlayer($showResult)];
    }

    /**
     * Get the game winner.
     *
     * @return Player
     */
    public function getWinner(): Player
    {
        print_r(PHP_EOL . "------------------------------" . PHP_EOL);

        print_r("恭喜玩家 {$this->winner->getName()} 獲得勝利, 分數為 {$this->winner->getScore()}!" . PHP_EOL);
        print_r("以下為分數結算:" . PHP_EOL);

        foreach ($this->playerList as $key => $player) {
            print_r("玩家 {$player->getName()} 分數為 {$player->getScore()}!" . PHP_EOL);
        }

        print_r("------------------------------" . PHP_EOL . PHP_EOL);

        return $this->winner;
    }
}
