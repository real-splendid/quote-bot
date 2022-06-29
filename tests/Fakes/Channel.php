<?php

namespace QuoteBotTests\Fakes;

use QuoteBot\Contracts\BotChannel;

class Channel implements BotChannel
{
    private array $channelsMessages = [];

    public function getBotId(): string
    {
        return 'fakeId';
    }

    public function isChannelAvailable(string $channelId): bool
    {
        return true;
    }

    public function send(string $channelId, string $text, int $delay = 0): void
    {
        $this->channelsMessages[$channelId] = $this->channelsMessages[$channelId] ?? [];
        $this->channelsMessages[$channelId][] = compact('text', 'delay');
    }

    public function deleteMessage(string $channelId, string $messageId): void
    {
        // TODO: 
    }

    public function getChannelMessages($channelId)
    {
        return $this->channelsMessages[$channelId] ?? [];
    }
}
