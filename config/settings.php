<?php

use Psr\Log\LogLevel;

return [
    'logLevel' => env('DISCORD_LOG_LEVEL', LogLevel::INFO),

    'bot' => [
        'token' => env('DISCORD_BOT_TOKEN'),
        'channelIds' => explode(',', env('DISCORD_BOT_CHANNEL_IDS', '')),
        'messageDelayInSeconds' => env('DISCORD_BOT_MESSAGE_DELAY_IN_SECONDS', 2),
        'welcomeText' => env('DISCORD_BOT_WELCOME_TEXT', ""),
        'cooldownInMinutes' => env('DISCORD_BOT_COOLDOWN_IN_MINUTES', 25),
        'masterUserIds' => explode(',', env('DISCORD_BOT_MASTER_USER_IDS', '')),
    ],

    'quotesPath' => __DIR__ . '/quotes.php',

    'themePatterns' => [
        'greeting' => '/\b(hi|hello|greet|greetings|good\s+morn)\b/iu',
        'bye' => '/\b(bye|goodbye|cya|see\s*ya|good\s*night|gonna\s+go)\b/iu',
        'xah' => '/\b(xah)\b/iu',
        'emacs' => '/\b(emacs)\b/iu',
        'unix' => '/\b(unix|linux|posix|bash)\b/iu',
        'microsoft' => '/\b(microsoft|ms|bill\s+gates)\b/iu',
        'programming' => '/\b(
            variable
            |source\s*code|software|computer\s+science
            |programmer|programming|programs?
            |javascript|python|golang
            )\b/xiu',
        'keyboard' => '/\b(keyboards?|shortcuts?)\b/iu',
        'other-code-editor' => '/\b(vim|vscode|sublime|jetbrains)\b/iu',
        'java' => '/\b(java|jvm|jdk|jre|jar|spring)\b/iu',
        'work' => '/\b(work|job)\b/iu',
        'bot' => '/\b(bot|robot|ai|parrot)\b/iu',
    ]
];
