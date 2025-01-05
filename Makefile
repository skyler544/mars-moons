all: Main

Main: composer
	php src/Main.php

test: composer
	composer test

composer: vendor

vendor: composer.json composer.lock
	composer install

autoload: composer
	composer dump-autoload

style-lint: composer
	composer style-lint

clean:
	rm -rf vendor/
