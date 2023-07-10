<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\Sprite;
use SoftwareDesign\Collision\Water;
use SoftwareDesign\Collision\Fire;
use SoftwareDesign\Collision\Hero;

abstract class CollisionHandler
{
    /**
     * The next handler in the chain.
     *
     * @var CollisionHandler|null
     */
    private ?CollisionHandler $next = null;

    public function __construct(CollisionHandler $next)
    {
        $this->next = $next;
    }

    /**
     * Check the pass in sprite whether match this handler.
     * If it is, handle it.
     * If not, check the next handler.
     *
     * @param Sprite $firSprite
     * @param Sprite $secSprite
     * @return void
     */
    public function match(Sprite $firSprite, Sprite $secSprite): void
    {
        if ($this->matchCondition($firSprite, $secSprite)) {
            $this->handle($firSprite, $secSprite);
        } else {
            $this->next->match($firSprite, $secSprite);
        }
    }

    /**
     * Check the pass in sprite whether match this handler.
     *
     * @param Sprite $firSprite
     * @param Sprite $secSprite
     * @return boolean
     */
    abstract public function matchCondition(Sprite $firSprite, Sprite $secSprite): bool;

    /**
     * After checking, handle the collision.
     *
     * @param Sprite $firSprite
     * @param Sprite $secSprite
     * @return void
     */
    abstract public function handle(Sprite $firSprite, Sprite $secSprite): void;
}

?>