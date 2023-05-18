<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

$matchMakingSystem = new MatchMakingSystem();

$individual = UserSetting::handleUserSetting(
    $matchMakingSystem->getHabitList(),
    count($matchMakingSystem->getIndividualList()),
    ['x' => 60, 'y' => 60]
);

print_r('請問你想要如何配對呢? (1. 距離配對, 2. 興趣配對): ');
$strategy = HandleInput::getInput();

print_r('請問你想要反轉結果嗎?(Y 或 N): ');
$reverse = HandleInput::getInput();

if ($reverse === 'Y' && $strategy === '1') {
    $matchMakingSystem->makePair($individual, new Reverse(new DistanceStrategy()));
} elseif ($reverse === 'Y' && $strategy === '2') {
    $matchMakingSystem->makePair($individual, new Reverse(new HabitStrategy()));
} elseif ($reverse === 'N') {
    if ($strategy === '1') {
        $matchMakingSystem->makePair($individual, new DistanceStrategy());
    } elseif ($strategy === '2') {
        $matchMakingSystem->makePair($individual, new HabitStrategy());
    } else {
        print_r('輸入錯誤，請重新輸入' . PHP_EOL);

        exit;
    }
}

print_r('最適合你的用戶 id 為: ' . $individual->getMostSuitable()->getId() . PHP_EOL);
