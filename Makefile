SHELL := /bin/bash

tests:
	/var/www/public/bin/console doctrine:database:drop --force --env=test || true
	/var/www/public/bin/console doctrine:database:create --env=test
	/var/www/public/bin/console doctrine:migrations:migrate -n --env=test
	/var/www/public/bin/console doctrine:fixtures:load -n --env=test
	/var/www/public/bin/phpunit
.PHONY: tests