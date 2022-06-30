<?php

namespace QuoteBot;

use Illuminate\Support\Collection;
use LogicException;
use Psr\Log\LoggerInterface;
use QuoteBot\Contracts\BotChannel;

class Bot
{
    private array $availableChannelIds = [];
    private array $channelCooldowns = [];
    private array $masterUserIds = [];
    private int $cooldownInMinutes = 0;
    private int $messageDelayInSeconds = 0;
    private array $quotes = [];
    private array $usedQuotesKeys = [];
    private array $themePatterns = [];
    private string $welcomeText;

    public function __construct(
        private BotChannel $botChannel,
        private array $settings,
        private LoggerInterface $logger
    ) {
        $this->messageDelayInSeconds = $this->settings['bot']['messageDelayInSeconds'];
        $this->welcomeText = $this->settings['bot']['welcomeText'];
        $this->cooldownInMinutes = $this->settings['bot']['cooldownInMinutes'];
        $this->masterUserIds = $this->settings['bot']['masterUserIds'];
        $this->themePatterns = $this->settings['themePatterns'];
        $this->quotes = require $this->settings['quotesPath'];

        $this->setupChannels($this->settings['bot']['channelIds']);
        $this->sendWelcomeMessage();
    }

    public function handleIncomingMessage(string $authorId, string $channelId, string $messageContent): void
    {
        if ($authorId === $this->botChannel->getBotId()) {
            return;
        }

        if (!in_array($channelId, $this->availableChannelIds)) {
            return;
        }

        $this->logger->info('received message', [$messageContent, $channelId]);
        if ($this->isOnCooldown($channelId)) {
            return;
        }

        $this->logger->info('handling message', [$messageContent]);

        if (hasCitation($messageContent)) {
            $this->logger->info('skip message with citation');
            return;
        }

        $responseQuote = $this->getResponseQuoteForText($messageContent);
        if ($responseQuote->isEmpty()) {
            return;
        }

        $this->channelCooldowns[$channelId]->start();
        $this->logger->info('Cooldown', [$this->channelCooldowns[$channelId]->toDateTimeLocalString()]);
        $citation = formatAsCitation($messageContent);
        $responseText = "{$citation}\n{$responseQuote}";
        $this->botChannel->send($channelId, $responseText, $this->messageDelayInSeconds);
    }

    public function handleReaction(
        string $channelId,
        string $messageId,
        string $reactionUserId,
        string $emojiName,
        string $messageAuthorId
    ) {
        if ($messageAuthorId !== $this->botChannel->getBotId()) {
            return;
        }

        $this->logger->info('received reaction', [$emojiName]);
        $shouldDeleteMessage = $emojiName === Emoji::RED_CROSS
            && in_array($reactionUserId, $this->masterUserIds);
        if ($shouldDeleteMessage) {
            $this->logger->info('deleting message', [$messageId]);
            $this->botChannel->deleteMessage($channelId, $messageId);
        }
    }

    private function setupChannels(array $channelIds): void
    {
        foreach ($channelIds as $channelId) {
            if ($this->botChannel->isChannelAvailable($channelId)) {
                $this->availableChannelIds[] = $channelId;
                $this->channelCooldowns[$channelId] = new Cooldown($this->cooldownInMinutes);
                $this->logger->info('channel added', [$channelId]);
            }
        }
    }

    private function sendWelcomeMessage(): void
    {
        if ($this->welcomeText === '') {
            return;
        }

        foreach ($this->availableChannelIds as $channelId) {
            $this->logger->info("Sending welcome message to channel {$channelId}");
            $this->botChannel->send($channelId, $this->welcomeText, 0);
        }
    }

    private function isOnCooldown(string $channelId): bool
    {
        return !$this->channelCooldowns[$channelId]->isReady();
    }

    /**
     * @throws LogicException
     */
    private function getResponseQuoteForText(string $text): Quote
    {
        $classifier = new RegexClassification($text, $this->themePatterns);
        $theme = $classifier->getFirstTheme();
        $this->logger->info('theme', [$theme]);
        if (!isset($this->quotes[$theme])) {
            return new Quote();
        }

        // FIXME
        $this->usedQuotesKeys[$theme] = $this->usedQuotesKeys[$theme] ?? [];
        $needInitUsedQuoteKeysSection = !isset($this->usedQuotesKeys[$theme])
            || count($this->usedQuotesKeys[$theme]) === count($this->quotes[$theme]);
        if ($needInitUsedQuoteKeysSection) {
            $this->usedQuotesKeys[$theme] = [];
        }
        $this->logger->info('usedQuoteKeys', $this->usedQuotesKeys);
        $key = Collection::make($this->quotes[$theme])
            ->filter(fn ($_, $k) => !in_array($k, $this->usedQuotesKeys[$theme]))
            ->keys()
            ->random();
        $this->logger->info('key', [$key]);
        $this->usedQuotesKeys[$theme][] = $key;
        $quote = $this->quotes[$theme][$key];
        $this->logger->info('quote', [$quote]);
        return $quote;
    }
}
