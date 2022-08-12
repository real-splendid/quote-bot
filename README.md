![static analysis](https://github.com/real-splendid/quote-bot/actions/workflows/lint.yml/badge.svg)
![test](https://github.com/real-splendid/quote-bot/actions/workflows/test.yml/badge.svg)

# Quote bot
This is quote bot for Discord. 

It analyzes the incoming messages in the configured channels and tries to reply with the proper quote.

## Requirements
* php 8.1
* composer
* make


## Usage
```Makefile
# Setup
make setup

# Check code
make analyse

# Fix code style automatically
make fix

# Run tests
make test

# Start bot
make run
```

> **Note**<br>
> For bot to work, after `make setup`, you need to configure DISCORD_BOT_TOKEN and DISCORD_BOT_CHANNEL_IDS env variables. You can do it in `.env` file.


## TODO
* add db with quotes and commands to manage them by admins
* save cooldown state in db
* add "theme cooldowns"
* add quotes

![parrot](https://user-images.githubusercontent.com/48528017/176316247-e408c0f1-0870-4a01-9981-358fadcb5cb5.jpg)
