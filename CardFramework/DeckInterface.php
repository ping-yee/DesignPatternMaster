<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\CardTemplate;

interface DeckInterface
{
    /**
     * Deck shuffle.
     *
     * @return array
     */
    public function shuffle(): array;

    /**
     * The getter of deck.
     *
     * @return array
     */
    public function getDeck(): array;

    /**
     * The player draw the card of deck.
     *
     * @param integer $cardIndex
     * @return CardTemplate
     */
    public function drawCard(int $cardIndex): CardTemplate;
}
