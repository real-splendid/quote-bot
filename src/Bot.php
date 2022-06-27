<?php

namespace QuoteBot;

use Dotenv\Dotenv;
use Illuminate\Support\Collection;
use LogicException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Bot
{
    private array $quotes = [];
    private array $usedQuoteKeys = [];
    private Cooldown $cooldown;
    public readonly LoggerInterface $logger;

    public string $id;
    public string $token;
    public array $channels = [];
    public int $messageDelayInSeconds = 0;
    public string $welcomeMessage;

    public function __construct()
    {
        $applicationPath = realpath(__DIR__ . '/..');
        $configPath = "{$applicationPath}/config";
        $dotenv = Dotenv::createImmutable($applicationPath);
        $dotenv->safeLoad();
        $settings = require_once "{$configPath}/settings.php";
        $this->id = $settings['botId'];
        $this->token = $settings['token'];
        $this->channels = $settings['botChannels'];
        $this->messageDelayInSeconds = $settings['botMessageDelay'];
        $this->welcomeMessage = $settings['botWelcomeMessage'];
        $this->themePatterns = $settings['themePatterns'];
        $this->logger = new Logger('bot');
        $this->logger->pushHandler(new StreamHandler('php://stdout', $settings['logLevel']));
        $this->cooldown = new Cooldown($settings['botCooldown'], $this->logger);
        $this->quotes = require_once "{$configPath}/quotes.php";
    }

    public function isOnCooldown()
    {
        return !$this->cooldown->isReady();
    }

    /**
     * @throws LogicException 
     */
    public function getResponseQuoteForText(string $text): Quote
    {
        if ($this->isOnCooldown()) {
            throw new LogicException("Can't get response while cooldown timer is on");
        }

        $classifier = new RegexClassification($text, $this->themePatterns);
        $theme = $classifier->getFirstTheme();
        $this->logger->info('theme', [$theme]);
        if (!isset($this->quotes[$theme])) {
            $this->logger->info('no replies for theme', [$theme]);
            return new Quote();
        }

        // FIXME
        $this->usedQuoteKeys[$theme] = $this->usedQuoteKeys[$theme] ?? [];
        $needInitUsedQuoteKeysSection = !isset($this->usedQuoteKeys[$theme])
            || count($this->usedQuoteKeys[$theme]) === count($this->quotes[$theme]);
        if ($needInitUsedQuoteKeysSection) {
            $this->usedQuoteKeys[$theme] = [];
        }
        $this->logger->info('usedQuoteKeys', $this->usedQuoteKeys);
        $key = Collection::make($this->quotes[$theme])
            ->filter(fn ($_, $k) => !in_array($k, $this->usedQuoteKeys[$theme]))
            ->keys()
            ->random();
        $this->logger->info('key', [$key]);
        $this->usedQuoteKeys[$theme][] = $key;
        $quote = $this->quotes[$theme][$key];
        $this->logger->info('quote', [$quote]);
        $this->cooldown->reset();
        return $quote;
    }
}
