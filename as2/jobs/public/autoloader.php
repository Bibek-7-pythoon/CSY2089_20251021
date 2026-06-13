<?php
spl_autoload_register(function (string $className): void {
    $classFile = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($classFile)) {
        require_once $classFile;
    }
});
