<?php

namespace SoftwareDesign\CardFramework;

require_once __DIR__ . DIRECTORY_SEPARATOR . "Autoload.php";

class CardTemplate
{
    /**
     * Getter.
     *
     * @param string $name
     * @return string
     */
    public function __get(string $name): string
    {
        return $this->{$name};
    }

    /**
     * Setter.
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set(string $name, string $value): void
    {
        $this->{$name} = $value;
    }
}
