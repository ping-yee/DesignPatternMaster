<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\Player;
use SoftwareDesign\CardFramework\CardTemplate;

class HumanPlayer extends Player
{
    /**
     * {@inheritDoc}
     */
    public function show(): CardTemplate
    {
        print_r("{$this->getName()} 你好, 目前你的手牌有以下 : " . PHP_EOL . PHP_EOL);

        $this->showNowCards();

        print_r("{$this->getName()} 你好, 請問你要丟出哪一張呢? (輸入第幾張, 範例: 1) : ");

        $showCardIndex = HandleInput::getInput() - 1;

        $card = $this->hands[$showCardIndex];

        if ($showCardIndex > count($this->hands)) {
            // throw Exception.
        }

        array_splice($this->hands, $showCardIndex, 1);

        return $card;
    }
}
