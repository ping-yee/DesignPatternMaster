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
    protected ?CollisionHandler $next = null;

    public function __construct(?CollisionHandler $next)
    {
        $this->next = $next;
    }

    /**
     * Check the pass in sprite whether match this handler.
     * If it is, handle it.
     * If not, check the next handler.
     *
     * @param array  $willBeHandledData
     * @return array return the world sprites array after collision.
     */
    public function match(array $willBeHandledData): array
    {
        $firstSprite  = $willBeHandledData['willMovedSprite'];
        $secondSprite = $willBeHandledData['willArrivedSprite'];

        if ($this->matchCondition($firstSprite, $secondSprite)) {
            return $this->handle($willBeHandledData);
        } else {
            if ($this->next === null) {
                print("尚未有此生命種類處理類別。" . PHP_EOL . PHP_EOL);

                return $willBeHandledData["sprites"];
            } else {
                return $this->next->match($willBeHandledData);
            }
        }
    }

    /**
     * Check the pass in sprite whether match this handler.
     *
     * @param Sprite $firstSprite
     * @param Sprite $secondSprite
     * @return boolean
     */
    abstract public function matchCondition(Sprite $firstSprite, Sprite $secondSprite): bool;

    /**
     * After checking, handle the collision.
     *
     * @param array  $willBeHandledData
     * @return array return the world sprites array after collision.
     */
    abstract public function handle(array $willBeHandledData): array;
}
