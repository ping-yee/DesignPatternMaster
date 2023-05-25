<?php

namespace SoftwareDesign\CardFramework;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\CardFramework\CardTemplate;

interface PlayerInterface
{
    /**
     * Set player name.
     *
     * @param string $name
     * @return PlayerInterface
     */
    public function setName(string $name): PlayerInterface;

    /**
     * The player show his/her card index in this turn.
     *
     * @param array|null $canShowCardsIndex
     * @return CardTemplate
     */
    public function show(?array $canShowCardsIndex = null): CardTemplate;

    /**
     * The setter of hands.
     *
     * @param CardTemplate $card
     * @return PlayerInterface
     */
    public function setHands(CardTemplate $card): PlayerInterface;

    /**
     * The getter of hands.
     *
     * @return Array
     */
    public function getHands(): array;

    /**
     * Add the player point
     *
     * @return PlayerInterface
     */
    public function addPoint(): PlayerInterface;
}
