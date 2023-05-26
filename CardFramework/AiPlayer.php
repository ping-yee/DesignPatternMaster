<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\CardTemplate;

class AiPlayer extends Player
{
    public function show(?array $canShowCardsIndex = null): CardTemplate
    {
        // I'm thinking...
        sleep(1);

        // Uno
        if ($canShowCardsIndex !== null) {
            if (count($canShowCardsIndex) === 1) {
                $showCardIndex = $canShowCardsIndex[0];
            } else {
                $randomIndex = random_int(0, count($canShowCardsIndex) - 1);
                $showCardIndex = $canShowCardsIndex[$randomIndex];
            }
        } else {
            if (count($this->hands) > 0) {
                $showCardIndex = random_int(0, count($this->hands) - 1);
            } else {
                $showCardIndex = 0;
            }
        }

        $card = $this->hands[$showCardIndex];

        array_splice($this->hands, $showCardIndex, 1);

        return $card;
    }
}
