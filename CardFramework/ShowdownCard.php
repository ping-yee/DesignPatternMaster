<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\CardTemplate;

class ShowdownCard extends CardTemplate
{
    /**
     * The rank of this card.
     *
     * @var string
     */
    protected string $rank;

    /**
     * The suit of this card.
     *
     * @var string
     */
    protected string $suit;

    public function __construct(string $rank, string $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }
}
