<?php

namespace QuoteBot;

use Discord\Parts\Channel\Message;
use QuoteBot\Contracts\ChannelMessage;

class DiscordMessage implements ChannelMessage
{
    public function __construct(private Message $message)
    {
    }

    public function getAuthorId(): string
    {
        return $this->message->author->id;
    }

    public function getChannelId(): string
    {
        return $this->message->channel_id;
    }

    public function getContent(): string
    {
        return $this->message->content;
    }
}
