<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\DeckTemplate;
use SoftwareDesign\CardFramework\UnoCard;

class UnoDeck extends DeckTemplate
{
    /**
     * Color list, used by mapping.
     *
     * @var array
     */
    protected array $colorList = ["", "", "", ""];

    /**
     * Init the showdown deck.
     */
    public function __construct()
    {
        // Number
        for ($number = 0; $number < 10; $number++) {
            // Color
            for ($color = 0; $color < 4; $color++) {
                array_push(
                    $this->deck,
                    new UnoCard(
                        (string) $number,
                        $this->colorMapping($color)
                    )
                );
            }
        }
    }

    /**
     * Put the deck back to deck.
     *
     * @param UnoCard $card
     * @return void
     */
    public function putCardBackToDeck(UnoCard $card): void
    {
        array_push($this->deck, $card);
    }

    /**
     * Color priority mapping.
     *
     * @param integer $suit
     * @return string
     */
    protected function colorMapping(int $color): string
    {
        if ($color === 0) {
            $this->colorList[3] = 'BLUE';
            return 'BLUE';
        } elseif ($color === 1) {
            $this->colorList[2] = 'RED';
            return 'RED';
        } elseif ($color === 2) {
            $this->colorList[1] = 'YELLOW';
            return 'YELLOW';
        } elseif ($color === 3) {
            $this->colorList[0] = 'GREEN';
            return 'GREEN';
        }

        return '';
    }
}
