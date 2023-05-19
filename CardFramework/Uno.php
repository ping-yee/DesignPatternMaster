<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\UnoDeck;
use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\CardGameTemplate;

class Uno extends CardGameTemplate
{
    /**
     * The setter of Deck.
     *
     * @return UnoDeck
     */
    public function setDeck(): CardGameInterface
    {
        $this->deck = new UnoDeck();
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
        while (true) {

            $player = $this->playerList[$playerIndex];
            $nowCard = null;

            if (empty($turnShowResult) === true) {
                print_r("------------------------------");
                print_r(PHP_EOL . "現在牌桌沒有牌, 請玩家 {$player->getName()} 率先出牌" . PHP_EOL);
                print_r("------------------------------" . PHP_EOL . PHP_EOL);
            } else {
                $nowCard = $turnShowResult[count($turnShowResult) - 1];
                print_r("------------------------------");
                print_r(PHP_EOL . "現在牌桌上牌為 {$nowCard} , 請出顏色或數字相仿的牌" . PHP_EOL);
                print_r("------------------------------" . PHP_EOL . PHP_EOL);
            }

            while (true) {
                $playerShowCard = $player->show();
                $isChecked = 
                
            }
            
            $turnShowResult[] = [
                "card"   => $playerShowCard,
                "player" => $player
            ];

            if ($playerIndex >= 4) {
                $playerIndex = 0;
            } else {
                $playerIndex += 1;
            }
            
            print_r("------------------------------");
            print_r(
                PHP_EOL . 
                "玩家 {$player->getName()} 出了 
                {$playerShowCard->__get('number')}
                {$playerShowCard->__get('color')}" . 
                PHP_EOL
            );
            print_r("------------------------------" . PHP_EOL . PHP_EOL);
        }
        
    }

    protected function searchSameColorOrNumber(CardTemplate $nowCard, PlayerInterface $nowPlayer): array
    {
        $canShowCardIndex = [];

        array_push(
            $canShowCardIndex,
            array_search($nowCard->__get("color"), $nowPlayer->getHands()),
            array_search($nowCard->__get("number"), $nowPlayer->getHands()),
        );
        
        return $canShowCardIndex;
    }

    protected function checkSameColorOrNumber(CardTemplate $nowCard, CardTemplate $playerShowCard): bool
    {
        $isChecked = false;

        if ($nowCard->__get("color") === $playerShowCard->__get("color")) {
            $isChecked = true;
        }

        if ($nowCard->__get("number") === $playerShowCard->__get("number")) {
            $isChecked = true;
        }

        return $isChecked;
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
        return $cardAmount > 20;
    }

    /**
     * {@inheritDoc}
     */
    protected function IsGameTurnOver(): bool
    {
        return $this->turn < 1;
    }
}
