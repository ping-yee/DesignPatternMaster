<?php

namespace SoftwareDesign\Poker;

include_once __DIR__ . "/Autoload.php";

use SoftwareDesign\Poker\Player;
use SoftwareDesign\Poker\Card;
use SoftwareDesign\Poker\Exchange;

class HumanPlayer extends Player
{
    /**
     * {@inheritDoc}
     */
    public function show(): Card
    {
        if ($this->exchange !== null) {
            $this->exchange->addTurn();

            if ($this->exchange->checkTurn() === true) {
                $this->exchange->changeBack();
            }
        }

        print_r("{$this->getName()} 你好, 目前你的手牌有以下 : " . PHP_EOL . PHP_EOL);

        $this->showNowCards();

        print_r("{$this->getName()} 你好, 請問你要丟出哪一張呢? (輸入第幾張, 範例: 1) : ");

        $showCardIndex = HandleInput::getInput() - 1;

        $card = $this->hands[$showCardIndex];

        if ($showCardIndex > count($this->hands)) {
            // throw Exception.
        }

        array_splice($this->hands, $showCardIndex, 1);

        return $card;
    }

    /**
     * {@inheritDoc}
     */
    public function isExchange(): bool
    {
        if ($this->isExchanged === true) {
            // throw Exception.
            return false;
        }

        print_r("{$this->getName()} 你好, 請問你是否要使用換牌特權(一場只能使用一次)? (範例: 是 或 否) : ");

        $isExchange = HandleInput::getInput();

        if ($isExchange === '是') {
            return true;
        } elseif ($isExchange === '否') {
            return false;
        } else {
            // throw Exception.
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function exchange(Player $player): PlayerInterface
    {
        print_r("{$this->getName()} 你好, 目前你的手牌有以下：" . PHP_EOL);

        $this->showNowCards();

        print_r("{$this->getName()} 你好, 請問你要拿哪一張去換呢? (輸入第幾張, 範例:1)");

        $exchangecardIndex = HandleInput::getInput() - 1;

        if (is_int($exchangecardIndex) === false) {
            // throw Exception.
            exit;
        }

        print_r("對方目前手牌有：" . PHP_EOL);

        $player->showNowCards();

        print_r("請問你拿對方哪一張呢? (輸入第幾張, 範例:1)");

        $exchangedcardIndex = HandleInput::getInput() - 1;

        if (is_int($exchangedcardIndex) === false) {
            // throw Exception.
            exit;
        }

        $this->exchange = new Exchange(
            $this,
            $exchangecardIndex,
            $player,
            $exchangedcardIndex
        );

        $this->isExchanged = true;

        return $this;
    }
}
