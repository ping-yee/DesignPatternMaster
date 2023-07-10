<?php

namespace SoftwareDesign\Collision;

include_once __DIR__ . '/Autoload.php';

abstract class Sprite
{
    /**
     * The coordinate of the sprite.
     *
     * @var CollisionHandler|null
     */
    private ?int $coordinate = null;

    /**
     * The type of the sprite.
     *
     * @var Hero|Water|Fire
     */
    private mixed $type = null;

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

    /**
     * Getter.
     *
     * @param string $name
     * @return Hero|Water|Fire|CollisionHandler|null
     */
    public function __get(string $name): mixed
    {
        return $this->{$name};
    }

}

?>