<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

use SoftwareDesign\CardFramework\Showdown;
use SoftwareDesign\CardFramework\Uno;
use SoftwareDesign\CardFramework\HandleInput;

print_r('請問你想要玩哪款遊戲呢 (請輸入 Uno 或 Showdown): ');
$game = HandleInput::getInput();

print_r(PHP_EOL . '載入中......' . PHP_EOL);
sleep(1);

if ($game === "Uno") {
    new Uno();
} elseif ($game === "Showdown") {
    new Showdown();
} else {
    print_r(PHP_EOL . '輸入錯誤，請重新載入' . PHP_EOL);
}
