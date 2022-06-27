<?php

namespace QuoteBot;

use Illuminate\Support\Str;

class TextWithCitation
{
    public function __construct(
        private string $text,
        private string $citation
    ) {
    }

    public function __toString(): string
    {
        $normalizedCitation = Str::of($this->citation)
            ->replace("\n", "\n> ");
        $resultText = "> {$normalizedCitation}\n{$this->text}";
        return $resultText;
    }
}
