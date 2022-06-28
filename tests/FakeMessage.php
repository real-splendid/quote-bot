<?php

namespace QuoteBotTests;

use QuoteBot\Contracts\ChannelMessage;

class FakeMessage implements ChannelMessage
{
    public function __construct(private string $channelId, private string $content)
    {
    }

    public function getAuthorId(): string
    {
        return 'fakeAuthorId';
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
