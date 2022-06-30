<?php

namespace QuoteBot;

use Illuminate\Support\Str;

function formatAsCitation(string $text): string
{
    return Str::of($text)
        ->replace("\n", "\n> ")
        ->prepend('> ');
}

function hasCitation(string $text): bool
{
    $textObject = Str::of($text);
    return $textObject->startsWith('>') || $textObject->contains("\n>");
}
