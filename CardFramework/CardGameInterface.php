<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\Player;

interface CardGameInterface
{
    /**
     * Set four Human\AI player.
     *
     * @return CardGameInterface
     */
    public function setPlayer(): CardGameInterface;

    /**
     * Set game using deck.
     *
     * @return CardGameInterface
     */
    public function setDeck(): CardGameInterface;

    /**
     * Set each player name.
     *
     * @param integer $playerIndex
     * @return CardGameInterface
     */
    public function setName(int $playerIndex): CardGameInterface;

    /**
     * Shuffle the card in the deck.
     *
     * @return CardGameInterface
     */
    public function shuffle(): CardGameInterface;

    /**
     * Each player draw the card from the deck.
     *
     * @return CardGameInterface
     */
    public function drawCard(): CardGameInterface;

    /**
     * The game start.
     *
     * @return CardGameInterface
     */
    public function turnStart(): CardGameInterface;

    /**
     * Get the winner by following the game rule.
     *
     * @return Player
     */
    public function getWinner(): Player;
}
