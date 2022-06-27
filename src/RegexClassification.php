<?php

namespace QuoteBot;

use Illuminate\Support\Collection;

class RegexClassification
{
    private Collection $themes;

    public function __construct(
        public readonly string $text,
        private array $themePatterns
    ) {
        $this->themes = Collection::make($this->themePatterns)
            ->filter(fn ($p) => preg_match($p, $this->text))
            ->keys();
    }

    public function getFirstTheme(): string
    {
        return $this->themes->first() ?? 'none';
    }
}
