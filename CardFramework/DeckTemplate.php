<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\DeckInterface;
use SoftwareDesign\CardFramework\CardTemplate;

abstract class DeckTemplate implements DeckInterface
{
    /**
     * Deck, lots of card included.
     * It will be better to save the deck with hashMap.
     *
     * @var array<CardTemplate>
     */
    protected array $deck = [];

    /**
     * Deck shuffle.
     *
     * @return array
     */
    public function shuffle(): array
    {
        if (shuffle($this->deck) !== true) {
            // throw Exception.
        }

        return $this->deck;
    }

    /**
     * The getter of deck.
     *
     * @return array
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * The player draw the card of deck.
     *
     * @param integer $cardIndex
     * @return CardTemplate
     */
    public function drawCard(int $cardIndex): CardTemplate
    {
        $card = $this->deck[$cardIndex];

        array_splice($this->deck, $cardIndex, 1);

        return $card;
    }
}
