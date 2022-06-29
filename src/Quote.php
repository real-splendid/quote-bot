<?php

namespace QuoteBot;

class Quote
{
    private const UNKNOWN = 'Unknown';

    public function __construct(
        public readonly string $text = '',
        public readonly string $source = self::UNKNOWN
    ) {
    }

    public function isEmpty(): bool
    {
        return $this->text === '';
    }

    public function isUnknownSource(): bool
    {
        return $this->source === self::UNKNOWN;
    }

    public function __toString(): string
    {
        $delimiter = ':small_orange_diamond:';
        return $this->isUnknownSource() ? $this->text : "{$this->text} {$delimiter} {$this->source}";
    }
}
