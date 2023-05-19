<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\CardTemplate;

class AiPlayer extends Player
{
    public function show(): CardTemplate
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
}
