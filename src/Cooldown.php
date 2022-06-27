<?php

namespace QuoteBot;

use Carbon\CarbonImmutable;
use Psr\Log\LoggerInterface;

class Cooldown
{
    private CarbonImmutable $readyTime;

    public function __construct(private int $intervalInMinutes, private LoggerInterface $logger)
    {
        $this->readyTime = CarbonImmutable::now();
    }

    public function reset()
    {
        $this->readyTime = CarbonImmutable::now()->addMinutes($this->intervalInMinutes);
        $this->logger->info('Cooldown reset', [$this->readyTime->toDateTimeLocalString()]);
    }

    public function isReady(): bool
    {
        $this->logger->info('readyTime', [$this->readyTime->toDateTimeLocalString()]);
        if (CarbonImmutable::now()->lessThan($this->readyTime)) {
            $this->logger->info('cooldown');
            return false;
        }

        return true;
    }
}
