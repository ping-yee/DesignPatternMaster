<?php

namespace SoftwareDesign\Match;

class HandleInput
{
    public static function getInput(): ?string
    {
        $handle = fopen('php://stdin', 'rb');
        $line   = fgets($handle);

        return trim($line);
    }
}
