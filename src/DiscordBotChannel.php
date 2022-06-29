<?php

namespace QuoteBot;

use Discord\Discord;
use QuoteBot\Contracts\BotChannel;

class DiscordBotChannel implements BotChannel
{
    private array $channelCache = [];

    public function __construct(private Discord $discord)
    {
    }

    public function getBotId(): string
    {
        return $this->discord->id;
    }

    public function isChannelAvailable($channelId): bool
    {
        return $this->getChannel($channelId) !== null;
    }

    public function send($channelId, $text, $delay = 0): void
    {
        $channel = $this->getChannel($channelId);
        if ($delay === 0) {
            $channel->sendMessage($text);
            return;
        }

        $this->discord->getLoop()->addTimer(
            $delay,
            fn () => $channel->sendMessage($text)
        );
    }

    public function deleteMessage(string $channelId, string $messageId): void
    {
        $this->discord->getChannel($channelId)->deleteMessages([$messageId]);
    }

    private function getChannel($channelId)
    {
        if (!isset($this->channelCache[$channelId])) {
            $this->channelCache[$channelId] = $this->discord->getChannel($channelId);
        }
        return $this->channelCache[$channelId];
    }
}
