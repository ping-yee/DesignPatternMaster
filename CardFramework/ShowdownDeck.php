<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\DeckTemplate;
use SoftwareDesign\CardFramework\ShowdownCard;

class ShowdownDeck extends DeckTemplate
{
    /**
     * Rank list, used by mapping.
     *
     * @var array
     */
    protected array $rankList = ["", "", "", "", "", "", "", "", "", "", "", "", ""];

    /**
     * Suit list, used by mapping.
     *
     * @var array
     */
    protected array $suitList = ["", "", "", ""];

    /**
     * Init the showdown deck.
     */
    public function __construct()
    {
        // Rank
        for ($rank = 1; $rank < 14; $rank++) {
            // Suit
            for ($suit = 0; $suit < 4; $suit++) {
                array_push(
                    $this->deck,
                    new ShowdownCard(
                        $this->rankMapping($rank),
                        $this->suitMapping($suit)
                    )
                );
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getHighestPlayer(array $showResult): int
    {
        $highestCard  = new ShowdownCard('2', 'Club');
        $highestIndex = 0;

        foreach ($showResult as $key => $card) {
            // The index is more small, than the weight is more big.
            $card = $card["card"];
            $highestRankWeight = array_search($highestCard->__get("rank"), $this->rankList);
            $highestSuitWeight = array_search($highestCard->__get("suit"), $this->suitList);
            $cardRankWeight    = array_search($card->__get("rank"), $this->rankList);
            $cardSuitWeight    = array_search($card->__get("suit"), $this->suitList);

            if ($cardRankWeight < $highestRankWeight) {
                $highestCard  = $card;
                $highestIndex = $key;
            } elseif ($cardRankWeight === $highestRankWeight) {
                if ($cardSuitWeight < $highestSuitWeight) {
                    $highestCard  = $card;
                    $highestIndex = $key;
                }
            }
        }

        return $highestIndex;
    }

    /**
     * Rank priority mapping
     *
     * @param integer $rank
     * @return string
     */
    protected function rankMapping(int $rank): string
    {
        if ($rank === 1) {
            $this->rankList[0] = 'A';
            return 'A';
        } elseif ($rank === 2) {
            $this->rankList[12] = '2';
            return '2';
        } elseif ($rank === 3) {
            $this->rankList[11] = '3';
            return '3';
        } elseif ($rank === 4) {
            $this->rankList[10] = '4';
            return '4';
        } elseif ($rank === 5) {
            $this->rankList[9] = '5';
            return '5';
        } elseif ($rank === 6) {
            $this->rankList[8] = '6';
            return '6';
        } elseif ($rank === 7) {
            $this->rankList[7] = '7';
            return '7';
        } elseif ($rank === 8) {
            $this->rankList[6] = '8';
            return '8';
        } elseif ($rank === 9) {
            $this->rankList[5] = '9';
            return '9';
        } elseif ($rank === 10) {
            $this->rankList[4] = '10';
            return '10';
        } elseif ($rank === 11) {
            $this->rankList[3] = 'J';
            return 'J';
        } elseif ($rank === 12) {
            $this->rankList[2] = 'Q';
            return 'Q';
        } elseif ($rank === 13) {
            $this->rankList[1] = 'K';
            return 'K';
        }

        return '';
    }

    /**
     * Suit priority mapping.
     *
     * @param integer $suit
     * @return string
     */
    protected function suitMapping(int $suit): string
    {
        if ($suit === 0) {
            $this->suitList[3] = 'Club';
            return 'Club';
        } elseif ($suit === 1) {
            $this->suitList[2] = 'Diamond';
            return 'Diamond';
        } elseif ($suit === 2) {
            $this->suitList[1] = 'Heart';
            return 'Heart';
        } elseif ($suit === 3) {
            $this->suitList[0] = 'Spade';
            return 'Spade';
        }

        return '';
    }
}
