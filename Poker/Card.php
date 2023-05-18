<?php

namespace SoftwareDesign\Poker;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

class Card
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

    public function __get($name)
    {
        return $this->{$name};
    }
}
