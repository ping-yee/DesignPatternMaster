<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\CollisionHandler;
use SoftwareDesign\Collision\Water;
use SoftwareDesign\Collision\Fire;
use SoftwareDesign\Collision\Hero;
use SoftwareDesign\Collision\HandleInput;

class World
{
    /**
     * The handler of the collision.
     *
     * @var CollisionHandler
     */
    protected CollisionHandler $handlers;

    /**
     * The sprites in the world and corresponding to the index.
     *
     * @var array
     */
    protected array $sprites = [];

    /**
     * Use DI to inject the handlers into the world.
     * And initial the world.
     *
     * @param CollisionHandler $handlers
     */
    public function __construct(CollisionHandler $handlers)
    {
        $this->handlers = $handlers;

        // Initial the world.
        $this->initialWorld();

        // Start the Game.
        $this->move();
    }

    /**
     * Initial the world, generate the sprites included.
     *
     * @return void
     */
    public function initialWorld(): void
    {
        $spriteCount = 0;

        for ($i = 0; $i < 30; $i++) {
            // Random generate the sprite into the world.
            if (random_int(0, 1) === 1 && $spriteCount < 10) {
                $spriteCount += 1;
            } else {
                array_push($this->sprites, null);
                continue;
            }

            // Decide the sprite type.
            $randomSpriteType = random_int(0, 2);

            if ($randomSpriteType === 0) {
                array_push($this->sprites, new Water($i));
            } elseif ($randomSpriteType === 1) {
                array_push($this->sprites, new Fire($i));
            } else {
                array_push($this->sprites, new Hero($i));
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
        while (true) {
            print_r('現在世界有以下生命：' . PHP_EOL);
            print_r('-----------------------------------' . PHP_EOL);

            foreach ($this->sprites as $index => $sprite) {
                if ($sprite === null) {
                    print_r("第 {$index} 個生物為 null" . PHP_EOL);
                } else {
                    print_r("第 {$index} 個生物為 {$sprite->getClassReflection()}" . PHP_EOL);
                }
            }

            print_r('-----------------------------------' . PHP_EOL);

            print_r('請問你移動哪一個座標的生命呢? (例: 0): ');

            $willMovedIndex = HandleInput::getInput();

            if ($this->sprites[$willMovedIndex] === null) {
                print_r('此座標無生物，請重新輸入。' . PHP_EOL . PHP_EOL);
                continue;
            }

            $willMovedSprite = $this->sprites[$willMovedIndex];

            print_r("此座標生物為 {$willMovedSprite->getClassReflection()}, 請問你要把它移到哪一個座標呢? (例: 3): ");

            $willArrivedIndex  = HandleInput::getInput();

            if ($this->sprites[$willArrivedIndex] === null) {
                // Move the sprite to the coordinate.
                $this->sprites[$willArrivedIndex] = $willMovedSprite;
                $this->sprites[$willMovedIndex]   = null;

                print_r("欲移動座標無生物, 移動成功。" . PHP_EOL . PHP_EOL);

                continue;
            } else {
                $willArrivedSprite = $this->sprites[$willArrivedIndex];

                $willBeHandledData = [
                    "willMovedIndex"    => $willMovedIndex,
                    "willMovedSprite"   => $willMovedSprite,
                    "willArrivedIndex"  => $willArrivedIndex,
                    "willArrivedSprite" => $willArrivedSprite,
                    "sprites"           => $this->sprites
                ];

                // Trigger the collision.
                $handledSprites = $this->handlers->match($willBeHandledData);

                $this->sprites = $handledSprites;
            }

            print_r("回合結束。" . PHP_EOL . PHP_EOL);

            sleep(1);
        }
    }
}
