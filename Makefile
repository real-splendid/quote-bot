setup: install copy-env

install:
	composer install

copy-env:
	cp --no-clobber .env.example .env

run:
	bin/quote-bot

test:
	vendor/bin/phpunit
