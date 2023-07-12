<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\CollisionHandler;
use SoftwareDesign\Collision\Water;
use SoftwareDesign\Collision\Fire;

class WaterAndFireHandler extends CollisionHandler
{
    /**
     * {@inheritDoc}
     */
    public function matchCondition(Sprite $firstSprite, Sprite $secondSprite): bool
    {
        if ($firstSprite instanceof Water && $secondSprite instanceof Fire) {
            return true;
        } elseif ($firstSprite instanceof Fire && $secondSprite instanceof Water) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function handle(array $willBeHandledData): array
    {
        print_r('觸發 Water 與 Fire 碰撞效果。' . PHP_EOL);

        // Get the sprites.
        $firstSprite  = $willBeHandledData['willMovedSprite'];
        $secondSprite = $willBeHandledData['willArrivedSprite'];

        // Set the sprite is dead.
        $firstSprite->__set("isExist", false);
        $secondSprite->__set("isExist", false);

        // Get the sprites index.
        $firstSpriteIndex  = $willBeHandledData['willMovedIndex'];
        $secondSpriteIndex = $willBeHandledData['willArrivedIndex'];

        // Handle the sprites array of world and return.
        $sprites = $willBeHandledData['sprites'];
        $sprites[$firstSpriteIndex]   = null;
        $sprites[$secondSpriteIndex]  = null;

        return $sprites;
    }
}
