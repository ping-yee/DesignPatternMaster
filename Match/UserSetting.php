<?php

namespace SoftwareDesign\Match;

include_once __DIR__ . '/Autoload.php';

class UserSetting
{
    public static function handleUserSetting(array $habitList, int $id, array $coord): Individual
    {
        print_r('請輸入你的性別: ');
        $gender = HandleInput::getInput();

        print_r('請輸入你的年紀 (不得低於 18): ');
        $age = HandleInput::getInput();

        print_r('請輸入你的自我介紹 (字數範圍 0 ~ 200): ');
        $intro = HandleInput::getInput();

        print_r(PHP_EOL . '以下是興趣列表 : ' . PHP_EOL);

        foreach ($habitList as $key => $habit) {
            $habitKey = $key + 1;
            print_r("第 {$habitKey} 個興趣為: {$habit}" . PHP_EOL);
        }

        print_r(PHP_EOL . '請選擇你的興趣並用逗號隔開(範例: 1,2,3): ');
        $habitSelected = HandleInput::getInput();

        $habitSelectedList = explode(',', $habitSelected);

        foreach ($habitSelectedList as $key => $value) {
            $habitSelectedList[$key] = (int) $value;
        }

        print_r(PHP_EOL . '------輸入完成-----' . PHP_EOL . PHP_EOL);

        return new Individual($id, $gender, $age, $intro, $habitSelectedList, $coord);
    }
}
