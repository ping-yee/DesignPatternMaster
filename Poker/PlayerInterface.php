<?php

namespace SoftwareDesign\Poker;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\Poker\Card;

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
     * The function will return whether the player need to exchange card.
     *
     * @return boolean
     */
    public function isExchange(): bool;

    /**
     * The function will call the exchangeCard() function of association class exchange.
     *
     * @param Player $player
     * @return PlayerInterface
     */
    public function exchange(Player $player): PlayerInterface;

    /**
     * The player show his/her card index in this turn.
     *
     * @return Card
     */
    public function show(): Card;

    /**
     * The setter of hands.
     *
     * @param Card $card
     * @return PlayerInterface
     */
    public function setHands(Card $card): PlayerInterface;

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
