<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\CollisionHandler;
use SoftwareDesign\Collision\Hero;
use SoftwareDesign\Collision\Fire;

class HeroAndFireHandler extends CollisionHandler
{
    /**
     * {@inheritDoc}
     */
    public function matchCondition(Sprite $firstSprite, Sprite $secondSprite): bool
    {
        if ($firstSprite instanceof Hero && $secondSprite instanceof Fire) {
            return true;
        } elseif ($firstSprite instanceof Fire && $secondSprite instanceof Hero) {
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
        print_r('觸發 Hero 與 Fire 碰撞效果。' . PHP_EOL);

        // Get the sprites.
        $firstSprite  = $willBeHandledData['willMovedSprite'];
        $secondSprite = $willBeHandledData['willArrivedSprite'];

        // Get the sprites index.
        $firstSpriteIndex  = $willBeHandledData['willMovedIndex'];
        $secondSpriteIndex = $willBeHandledData['willArrivedIndex'];

        // Handle the sprites array of world and return.
        $sprites = $willBeHandledData['sprites'];

        // Set the sprite is dead.
        if ($firstSprite instanceof Hero) {
            print_r("目前此 Hero 血量為 {$firstSprite->__get("Hp")}" . PHP_EOL);

            $firstSprite->__set("Hp", $firstSprite->__get("Hp") - 10);
            $secondSprite->__set("isExist", false);

            $sprites[$firstSpriteIndex]   = null;
            $sprites[$secondSpriteIndex]  = $firstSprite;

            print_r("碰撞完後 Hero 血量為 {$firstSprite->__get("Hp")}" . PHP_EOL);
        } else {
            print_r("目前此 Hero 血量為 {$secondSprite->__get("Hp")}" . PHP_EOL);

            $firstSprite->__set("isExist", false);
            $secondSprite->__set("Hp", $secondSprite->__get("Hp") - 10);

            print_r("碰撞完後 Hero 血量為 {$secondSprite->__get("Hp")}" . PHP_EOL);

            $sprites[$firstSpriteIndex] = null;

            // Check whether the Hero is dead or not.
            if ($secondSprite->__get("Hp") <= 0) {
                print_r('Hero 生命歸零。' . PHP_EOL);
                $sprites[$secondSpriteIndex]  = null;
            }
        }

        return $sprites;
    }
}
