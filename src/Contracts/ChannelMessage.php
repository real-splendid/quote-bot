<?php

namespace QuoteBot\Contracts;

interface ChannelMessage
{
    public function getAuthorId(): string;
    public function getChannelId(): string;
    public function getContent(): string;
}
