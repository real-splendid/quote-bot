setup: install copy-env

install:
	composer install

copy-env:
	cp --no-clobber .env.example .env

run:
	bin/quote-bot

test:
	vendor/bin/phpunit

analyse: phpcs phpmd phpstan

phpcs:
	vendor/bin/phpcs src/ helpers/ --standard=PSR12

phpstan:
	vendor/bin/phpstan analyse src/ helpers/ --level 5

phpmd:
	vendor/bin/phpmd src/ ansi cleancode,codesize,controversial,design

fix:
	vendor/bin/phpcbf src/ helpers/ --standard=PSR12
	vendor/bin/php-cs-fixer fix src/ --rules=@PSR12
	vendor/bin/php-cs-fixer fix helpers/ --rules=@PSR12
