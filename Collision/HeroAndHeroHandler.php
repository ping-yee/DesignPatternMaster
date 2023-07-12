<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\CollisionHandler;

class HeroAndHeroHandler extends CollisionHandler
{
    /**
     * {@inheritDoc}
     */
    public function matchCondition(Sprite $firstSprite, Sprite $secondSprite): bool
    {
        if ($firstSprite instanceof Hero && $secondSprite instanceof Hero) {
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
        print_r('觸發 Hero 與 Hero 碰撞效果。' . PHP_EOL);

        // Handle the sprites array of world and return.
        $sprites = $willBeHandledData['sprites'];

        return $sprites;
    }
}
