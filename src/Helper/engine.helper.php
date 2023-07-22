<?php

if (!function_exists("inheritance")) {
    function inheritance(string $fileName): string
    {
        return sprintf("@inheritance(%s)@", $fileName);
    }
}

if (!function_exists("block")) {
    function block(string $blockName): string
    {
        return sprintf("@block(%s)@", $blockName);
    }
}

if (!function_exists("endBlock")) {
    function endBlock(string $blockName): string
    {
        return sprintf("@endBlock(%s)@", $blockName);
    }
}
