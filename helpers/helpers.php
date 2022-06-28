<?php

namespace QuoteBot;

use Illuminate\Support\Str;

function formatAsCitation(string $text): string
{
    return Str::of($text)
        ->replace("\n", "\n> ")
        ->prepend('> ');
}
