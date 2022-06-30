<?php

namespace QuoteBotTests;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use QuoteBot\Bot;
use QuoteBotTests\Fakes\Channel;

class BotTest extends TestCase
{
    public function setup(): void
    {
        parent::setUp();

        srand(1);
        $this->welcomeText = 'test welcome text';
        $this->firstChannelId = 'channel1';
        $this->secondChannelId = 'channel2';
        $this->messenger = new Channel();
        // FIXME: 
        $fakeSettings = require __DIR__ . '/../config/settings.php';
        $fakeSettings['bot'] = array_merge(
            $fakeSettings['bot'],
            [
                'channelIds' => [$this->firstChannelId, $this->secondChannelId],
                'welcomeText' => $this->welcomeText,

            ]
        );
        $this->bot = new Bot($this->messenger, $fakeSettings, new NullLogger());
    }

    public function testWelcomeMessage()
    {
        $expectedChannelMessages = [['text' => $this->welcomeText, 'delay' => 0]];

        $firstChannelMessages = $this->messenger->getChannelMessages($this->firstChannelId);
        $secondChannelMessages = $this->messenger->getChannelMessages($this->secondChannelId);
        $otherChannelMessages = $this->messenger->getChannelMessages('other');

        $this->assertSame($expectedChannelMessages, $firstChannelMessages);
        $this->assertSame($expectedChannelMessages, $secondChannelMessages);
        $this->assertSame([], $otherChannelMessages);
    }

    public function testHandleIncomingMessages()
    {
        $otherChannelId = 'other';

        $this->bot->handleIncomingMessage('authorId', $this->firstChannelId, 'question about emacs');
        $this->bot->handleIncomingMessage('authorId', $this->secondChannelId, 'question about vim');
        $this->bot->handleIncomingMessage('authorId', $otherChannelId, 'question about emacs');
        $firstChannelMessages = $this->messenger->getChannelMessages($this->firstChannelId);
        $secondChannelMessages = $this->messenger->getChannelMessages($this->secondChannelId);
        $otherChannelMessages = $this->messenger->getChannelMessages($otherChannelId);

        $this->assertCount(2, $firstChannelMessages);
        $this->assertCount(2, $secondChannelMessages);
        $this->assertNotSame($firstChannelMessages[1], $secondChannelMessages[1]);
        $this->assertSame(2, $firstChannelMessages[1]['delay']);
        $this->assertMatchesRegularExpression('/emacs.+unix|\s*Tom/iu', $firstChannelMessages[1]['text']);
        $this->assertMatchesRegularExpression('/vim.+exit/iu', $secondChannelMessages[1]['text']);
        $this->assertSame([], $otherChannelMessages);
    }

    public function testNotRespondCitation()
    {
        $messageText1 = "> some citation\nxah theme";
        // $messageText1 = "> line 1\n> line2\nxah";

        $channelMessagesBefore = $this->messenger->getChannelMessages($this->firstChannelId);
        $this->bot->handleIncomingMessage('authorId', $this->firstChannelId, $messageText1);
        $channelMessagesAfter = $this->messenger->getChannelMessages($this->firstChannelId);

        $this->assertCount(1, $channelMessagesBefore);
        $this->assertCount(1, $channelMessagesAfter);
    }
}
