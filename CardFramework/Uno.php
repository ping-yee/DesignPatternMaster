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
     * @return CardGameInterface
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
            $player  = $this->playerList[$playerIndex];

            if (empty($turnShowResult) === true) {
                $turnShowResult[] = [
                    "card"   => $this->deck->drawCard(count($this->deck->getDeck()) - 1),
                    "player" => $player
                ];
                
                print_r("------------------------------");
                print_r(
                    PHP_EOL . 
                    "現在牌桌沒有牌, 從牌堆翻出第一張牌為: {$this->turnCardInstanceToString($turnShowResult[0])}" . 
                    PHP_EOL
                );
                print_r("------------------------------" . PHP_EOL . PHP_EOL);
            } else {
                print_r("------------------------------");
                print_r(
                    PHP_EOL . 
                    "現在牌桌上牌為 {$this->turnCardInstanceToString($turnShowResult[count($turnShowResult) - 1])} , 請出顏色或數字相仿的牌" . 
                    PHP_EOL
                );
                print_r("------------------------------" . PHP_EOL . PHP_EOL);
            }

            // Top card in the table.
            $nowCard          = $turnShowResult[count($turnShowResult) - 1];
            $isPlayerCantShow = (empty($this->searchSameColorOrNumber($nowCard, $player)) === true);

            if ($isPlayerCantShow) {
                print_r("------------------------------");
                print_r(PHP_EOL . "玩家 {$player->getName()} 你好,你沒有任何牌可以出,系統自動幫你抽排" . PHP_EOL);
                print_r("------------------------------" . PHP_EOL . PHP_EOL);

                $deck = $this->deck->getDeck();

                if (count($deck) === 0) {
                    foreach ($turnShowResult as $key => $card) {
                        $this->deck->putCardBackToDeck();
                    }
                    
                }

                // Player draw the top card of the deck.
                $player->setHands(
                    $this->deck->drawCard(
                        count($deck) - 1
                    )
                );
            } else {
                $playerShowCard = $player->show();
            }

            if (empty($turnShowResult) === false) {
                $colorOrNumberIsChecked = $this->checkSameColorOrNumber(
                    $turnShowResult[count($turnShowResult) - 1],
                    $playerShowCard
                );

                // Loop until the player show the current card.
                while ($colorOrNumberIsChecked === false && $this->searchSameColorOrNumber($nowCard, $player)) {
                    print_r(
                        PHP_EOL .
                        "你出的卡片為： {$this->turnCardInstanceToString($playerShowCard)} , 但現在檯面上的卡片為 {$this->turnCardInstanceToString($playerShowCard)}" . 
                        PHP_EOL);

                    // Put the wrong card back to player hands.
                    $player->setHands($playerShowCard);
                }
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

            if ($player) {
                # code...
            }
        }
        
    }

    /**
     * Find out the player can show card(s).
     * If there is any card can show, it will return the empty array.
     *
     * @param UnoCard $nowCard
     * @param PlayerInterface $nowPlayer
     * @return array
     */
    protected function searchSameColorOrNumber(UnoCard $nowCard, PlayerInterface $nowPlayer): array
    {
        $canShowCardIndex = [];

        array_push(
            $canShowCardIndex,
            array_search($nowCard->__get("color"), $nowPlayer->getHands()),
            array_search($nowCard->__get("number"), $nowPlayer->getHands()),
        );
        
        return $canShowCardIndex;
    }

    /**
     * Check whether the player shows card can show.
     *
     * @param UnoCard $nowCard
     * @param UnoCard $playerShowCard
     * @return boolean
     */
    protected function checkSameColorOrNumber(UnoCard $nowCard, UnoCard $playerShowCard): bool
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

    /**
     * return the card info.
     *
     * @param CardTemplate $card
     * @return string
     */
    protected function turnCardInstanceToString(CardTemplate $card): string
    {
        return "{$card->__get('number')} {$card->__get('color')}";
    }
}
