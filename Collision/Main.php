<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

use SoftwareDesign\Collision\World;
use SoftwareDesign\Collision\WaterAndFireHandler;
use SoftwareDesign\Collision\WaterAndWaterHandler;
use SoftwareDesign\Collision\FireAndFireHandler;
use SoftwareDesign\Collision\HeroAndFireHandler;
use SoftwareDesign\Collision\HeroAndWaterHandler;
use SoftwareDesign\Collision\HeroAndHeroHandler;

$world = new World(
    new WaterAndFireHandler(
        new WaterAndWaterHandler(
            new FireAndFireHandler(
                new HeroAndFireHandler(
                    new HeroAndWaterHandler(
                        new HeroAndHeroHandler(null)
                    )
                )
            )
        )
    )
);
