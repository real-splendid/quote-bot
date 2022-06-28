<?php

namespace QuoteBot\Contracts;

interface ChannelMessenger
{
    public function getId(): string;
    public function isChannelAvailable($channelId): bool;
    public function send($channelId, $text, $delay): void;
}
