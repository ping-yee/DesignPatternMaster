<?php

namespace SoftwareDesign\CardFramework;

class HandleInput
{
    public static function getInput(): ?string
    {
        $handle = fopen("php://stdin", "r");
        $line   = fgets($handle);

        return trim($line);
    }
}
