<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\Sprite;

class Hero extends Sprite
{
    /**
     * When $Hp reaches 0, the hero dies.
     *
     * @var integer
     */
    private int $Hp = 30;
}