<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\CardTemplate;

class UnoCard extends CardTemplate
{
    /**
     * The color of this card.
     *
     * @var string
     */
    protected string $color;

    /**
     * The number of this card.
     *
     * @var string
     */
    protected string $number;

    public function __construct(string $number, string $color)
    {
        $this->number = $number;
        $this->color = $color;
    }
}
