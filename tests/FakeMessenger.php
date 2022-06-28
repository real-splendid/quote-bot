<?php

namespace QuoteBotTests;

use QuoteBot\Contracts\ChannelMessenger;

class FakeMessenger implements ChannelMessenger
{
    private array $channelsMessages = [];

    public function getId(): string
    {
        return 'fakeId';
    }

    public function isChannelAvailable($channelId): bool
    {
        return true;
    }

    public function send($channelId, $text, $delay = 0): void
    {
        $this->channelsMessages[$channelId] = $this->channelsMessages[$channelId] ?? [];
        $this->channelsMessages[$channelId][] = compact('text', 'delay');
    }

    public function getChannelMessages($channelId)
    {
        return $this->channelsMessages[$channelId] ?? [];
    }
}
