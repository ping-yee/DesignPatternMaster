<?php

namespace SoftwareDesign\Poker;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\Poker\Player;
use SoftwareDesign\Poker\Card;

class AiPlayer extends Player
{
    public function show(): Card
    {
        if (count($this->hands) - 1 > 0) {
            $showCardIndex = random_int(0, count($this->hands) - 1);
        } else {
            $showCardIndex = 0;
        }

        $card = $this->hands[$showCardIndex];

        array_splice($this->hands, $showCardIndex, 1);

        return $card;
    }

    /**
     * It will never be called.
     *
     * @return boolean
     */
    public function isExchange(): bool
    {
        return false;
    }

    /**
     * It will never be called.
     *
     * @param Player $player
     * @return PlayerInterface
     */
    public function exchange(Player $player): PlayerInterface
    {
        return $this;
    }
}
