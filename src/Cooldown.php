<?php

namespace QuoteBot;

use Carbon\CarbonImmutable;

class Cooldown
{
    private CarbonImmutable $readyTime;

    public function __construct(private int $intervalInMinutes)
    {
        $this->readyTime = new CarbonImmutable();
    }

    public function start(): void
    {
        $this->readyTime = CarbonImmutable::now()->addMinutes($this->intervalInMinutes);
    }

    public function isReady(): bool
    {
        return CarbonImmutable::now()->greaterThanOrEqualTo($this->readyTime);
    }

    public function toDateTimeLocalString(): string
    {
        return $this->readyTime->toDateTimeLocalString();
    }
}
