<?php

spl_autoload_register(function ($className) {
    $className = explode('\\', $className)[2];

    require_once __DIR__ . DIRECTORY_SEPARATOR ."{$className}.php";
});
