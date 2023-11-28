PROJECT_DIR=$(shell pwd)
PROJECT_NAME=$(shell basename "${PROJECT_DIR}")
PHP_CONTAINER_NAME=nfs-fpm
BIN_CONSOLE=docker-compose exec ${PHP_CONTAINER_NAME} bin/console
CODECEPT=docker-compose exec ${PHP_CONTAINER_NAME} ./vendor/bin/codecept
VENDOR_BIN=vendor/bin
CONTAINER_ID=$(shell docker ps|grep "${PHP_CONTAINER_NAME}"|cut -d' ' -f1)
DOCKER_BASH=docker exec -u 0 -it ${CONTAINER_ID} /bin/bash

# Colors
G=\033[32m
Y=\033[33m
NC=\033[0m

##
## Help
## ----

help: ## List of all commands
	@grep -E '(^[a-zA-Z_0-9-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
	| awk 'BEGIN {FS = ":.*?## "}; {printf "${G}%-24s${NC} %s\n", $$1, $$2}' \
	| sed -e 's/\[32m## /[33m/' && printf "\n"; \
	printf "Project: ${Y}${PROJECT_NAME}${NC}\n"; \
	printf "Project directory: ${Y}${PROJECT_DIR}${NC}\n\n";

.DEFAULT_GOAL := help
.PHONY: help

##
## Docker commands
## ---------------
up: ## Up
	docker-compose up -d
	sleep 5
	$(BIN_CONSOLE) d:d:c --if-not-exists -n
	$(BIN_CONSOLE) d:m:m -n

down: ## Stop and remove
	docker-compose down

restart: down up ## Restart

bash-fpm: ## Launch bash inside PHP container
	docker-compose exec ${PHP_CONTAINER_NAME} bash

composer-update: ## Update composer packages
	docker-compose exec ${PHP_CONTAINER_NAME} composer update --no-interaction

##
## Database commands
## -----------------

mig-diff: ## Generate a migration by comparing your current database to your mapping information
	$(BIN_CONSOLE) d:m:diff

mig-apply: ## Execute all migrations
	$(BIN_CONSOLE) d:m:m -n

db-create: ## Init DB structure
	$(BIN_CONSOLE) doctrine:database:create

##
## Stat analyse commands
## -----------------

lint: ## Run PHPStan analyse
	docker-compose up -d
	docker-compose exec ${PHP_CONTAINER_NAME} ./vendor/bin/phpstan analyse

setup: ## Init setup process
	cp .env.dist .env
	docker-compose build
	docker-compose up -d
	docker-compose exec ${PHP_CONTAINER_NAME} composer install --no-interaction
	$(BIN_CONSOLE) doctrine:database:create --if-not-exists -n

rebuild:
	make down && \
	docker-compose build ${PHP_CONTAINER_NAME}

csfix: ## Run the fixer on src directory without options
	docker-compose exec ${PHP_CONTAINER_NAME} $(VENDOR_BIN)/php-cs-fixer fix src --allow-risky=yes --using-cache=no

csfix-dry: ## Run the fixer on src directory without making changes
	docker-compose exec ${PHP_CONTAINER_NAME} $(VENDOR_BIN)/php-cs-fixer fix src --dry-run --diff --using-cache=no

bash:
	exec ${DOCKER_BASH}
##
## Test commands
## -----------------

run-tests: ## run all tests
	$(CODECEPT) run

clean-tests: ## run all tests
	$(CODECEPT) clean