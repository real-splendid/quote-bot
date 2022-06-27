<?php

use Psr\Log\LogLevel;

return [
    'token' => env('DISCORD_BOT_TOKEN'),
    'botId' => env('DISCORD_BOT_ID'),
    'botChannels' => json_decode(env('DISCORD_BOT_HOME_CHANNELS', '[]'), true),
    'botMessageDelay' => env('DISCORD_BOT_MESSAGE_DELAY', 2),
    'botWelcomeMessage' => env('DISCORD_BOT_WELCOME_MESSAGE', ""),
    'botCooldown' => env('DISCORD_BOT_COOLDOWN', 25),

    'logLevel' => env('DISCORD_BOT_LOG_LEVEL', LogLevel::INFO),

    'themePatterns' => [
        'greeting' => '/\b(hi|hello|greet|greetings|good\s+morn)\b/iu',
        'bye' => '/\b(bye|goodbye|cya|see\s*ya|good\s*night|gonna\s+go)\b/iu',
        'support' => '/\b(
            it\'s\s+hard|very\s+hard
            need\s+help|can\'t\s+do
            )\b/xiu',
        'programming' => '/\b(
            variable
            |source\s*code|software|computer\s+science
            |programmer|programming|programs?
            |javascript|python|golang
            )\b/xiu',
        'keyboard' => '/\b(keyboards?|shortcuts?)\b/iu',
        'bot' => '/\b(bot|robot|ai|parrot)\b/iu',
        'emacs' => '/\b(emacs)\b/iu',
        'code-editor-other' => '/\b(vim|vscode|sublime|jetbrains)\b/iu',
        'unix' => '/\b(unix|linux|posix|bash)\b/iu',
        'microsoft' => '/\b(microsoft|ms|bill\s+gates)\b/iu',
        'java' => '/\b(java|jvm|jdk|jre|jar|spring)\b/iu',
        'work' => '/\b(work|job)\b/iu',
    ]
];
