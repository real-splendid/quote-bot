<?php

namespace QuoteBotTests;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use QuoteBot\Bot;

class BotTest extends TestCase
{
    public function setup(): void
    {
        parent::setUp();

        srand(1);
        $this->welcomeText = 'test welcome text';
        $this->firstChannelId = 'channel1';
        $this->secondChannelId = 'channel2';
        $this->fakeMessenger = new FakeMessenger();
        // FIXME: 
        $fakeSettings = array_merge(
            require __DIR__ . '/../config/settings.php',
            ['bot' => [
                'channelIds' => [$this->firstChannelId, $this->secondChannelId],
                'welcomeText' => $this->welcomeText,
                'messageDelayInSeconds' => 1,
                'cooldownInMinutes' => 2,
            ]]
        );
        $this->bot = new Bot($this->fakeMessenger, $fakeSettings, new NullLogger());
    }

    public function testWelcomeMessage()
    {
        $expectedChannelMessages = [['text' => $this->welcomeText, 'delay' => 0]];

        $firstChannelMessages = $this->fakeMessenger->getChannelMessages($this->firstChannelId);
        $secondChannelMessages = $this->fakeMessenger->getChannelMessages($this->secondChannelId);
        $otherChannelMessages = $this->fakeMessenger->getChannelMessages('other');
        
        $this->assertSame($expectedChannelMessages, $firstChannelMessages);
        $this->assertSame($expectedChannelMessages, $secondChannelMessages);
        $this->assertSame([], $otherChannelMessages);
    }

    public function testHandleIncomingMessages()
    {
        $otherChannelId = 'other';
        $messageFromFirstChannel = new FakeMessage($this->firstChannelId, 'question about emacs');
        $messageFromSecondChannel = new FakeMessage($this->secondChannelId, 'question about vim');
        $messageFromOtherChannel = new FakeMessage($otherChannelId, 'other about vim');

        $this->bot->handleIncomingMessage($messageFromFirstChannel);
        $this->bot->handleIncomingMessage($messageFromSecondChannel);
        $this->bot->handleIncomingMessage($messageFromOtherChannel);
        $firstChannelMessages = $this->fakeMessenger->getChannelMessages($this->firstChannelId);
        $secondChannelMessages = $this->fakeMessenger->getChannelMessages($this->secondChannelId);
        $otherChannelMessages = $this->fakeMessenger->getChannelMessages($otherChannelId);

        $this->assertCount(2, $firstChannelMessages);
        $this->assertCount(2, $secondChannelMessages);
        $this->assertNotSame($firstChannelMessages[1], $secondChannelMessages[1]);
        $this->assertSame(1, $firstChannelMessages[1]['delay']);
        $this->assertMatchesRegularExpression('/emacs.+unix|\s*Tom/iu', $firstChannelMessages[1]['text']);
        $this->assertMatchesRegularExpression('/vim.+exit/iu', $secondChannelMessages[1]['text']);
        $this->assertSame([], $otherChannelMessages);
    }
}
