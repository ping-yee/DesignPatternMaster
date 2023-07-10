<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\CollisionHandler;
use SoftwareDesign\Collision\Water;
use SoftwareDesign\Collision\Fire;
use SoftwareDesign\Collision\Hero;

class World
{
    /**
     * The handler of the collision.
     *
     * @var CollisionHandler
     */
    private CollisionHandler $handlers;

    /**
     * The sprites in the world.
     *
     * @var array
     */
    private array $sprites = [];

    /**
     * Initial the world, generate the sprites included.
     *
     * @return void
     */
    public function initialWorld(): void
    {
        $randomSpriteIndex = random_int(0, 2);

        for ($i = 0; $i < 10; $i++) {
            if ($randomSpriteIndex === 0) {
                array_push($this->sprites, new Water());
            } else if ($randomSpriteIndex === 1) {
                array_push($this->sprites, new Fire());
            } else {
                array_push($this->sprites, new Hero());
            }
        }
    }

    /**
     * Move the sprites in the world.
     * 
     * User will input the coordinate and the sprite will move to the coordinate.
     * May trigger some collision.
     *
     * @return void
     */
    public function move(): void
    {
        
    }
}

?>