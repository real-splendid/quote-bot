<?php

namespace QuoteBot\Contracts;

interface BotChannel
{
    public function getBotId(): string;
    public function isChannelAvailable(string $channelId): bool;
    public function send(string $channelId, string $text, int $delay): void;
    public function deleteMessage(string $channelId, string $messageId): void;
}
