<?php

if (!function_exists('storagePath')) {
    function storagePath(string $subPath): string
    {
        return __DIR__ . '/../../../storage/' . $subPath;
    }
}

if (!function_exists('configPath')) {
    function configPath(string $subPath): string
    {
        return __DIR__ . '/../../../config/' . $subPath;
    }
}

if (!function_exists('echoArray')) {
    function echoArray(array $arr = []): void
    {
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
    }
}

if (!function_exists('readFileLine')) {
    function readFileLine(string $filename): array
    {
        exec(dirname(__DIR__, 3) . '/bin/readFile', $test, $return_var);
        return $test;
    }
}