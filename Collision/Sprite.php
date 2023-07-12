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
    protected ?int $coordinate = null;

    /**
     * The type of the sprite.
     *
     * @var Hero|Water|Fire
     */
    protected mixed $type = null;

    /**
     * Store the sprite whether it is exist or not.
     *
     * @var boolean
     */
    protected bool $isExist = true;

    /**
     * Set the sprite coordinate.
     */
    public function __construct(?int $coordinate = null)
    {
        if (is_null($coordinate) === true) {
            $this->coordinate = random_int(0, 29);
        } else {
            $this->coordinate = $coordinate;
        }
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

    /**
     * Get the class name without namespace.
     *
     * @return string
     */
    public function getClassReflection(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
