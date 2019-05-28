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