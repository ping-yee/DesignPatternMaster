<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\ShowdownDeck;
use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\CardGameTemplate;

class Showdown extends CardGameTemplate
{
    /**
     * The setter of Deck.
     *
     * @return Showdown
     */
    public function setDeck(): CardGameInterface
    {
        $this->deck = new ShowdownDeck();
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function eachPlayerShow(): void
    {
        $playerIndex = 0;

        $turnShowResult = [];

        // Player takes a turn.
        while ($playerIndex < count($this->playerList)) {
            $player = $this->playerList[$playerIndex];

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
        print_r("第 " . ($this->turn + 1) . " 回合結算:" . PHP_EOL . PHP_EOL);


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

        // Give the default winner.
        if ($this->winner === null) {
            $this->winner = $this->playerList[0];
        }

        if ($highestPlayer->getScore() > $this->winner->getScore()) {
            $this->winner = $highestPlayer;
        }

        $this->turn += 1;

        print_r("------------------------------" . PHP_EOL . PHP_EOL);
    }

    /**
     * {@inheritDoc}
     */
    public function getHighestPlayer(array $showResult): Player
    {
        return $this->playerList[$this->deck->getHighestPlayer($showResult)];
    }

    /**
     * {@inheritDoc}
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

    /**
     * {@inheritDoc}
     */
    protected function IsOverDrawCardAmount(int $cardAmount): bool
    {
        return $cardAmount > 0;
    }

    /**
     * {@inheritDoc}
     */
    protected function IsGameTurnOver(): bool
    {
        return $this->turn < 13;
    }

    /**
     * {@inheritDoc}
     */
    public function setPlayerGame(): CardGameInterface
    {
        foreach ($this->playerList as $player) {
            $player->setGame('Showdown');
        }

        return $this;
    }
}
