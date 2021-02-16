-include .env
.DEFAULT_GOAL := help
.PHONY: $(filter-out vendor, $(MAKECMDGOALS))

help: ## Show this help message
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

autoloader: ## Dump the Composer autoloader
	@composer dumpautoload

test: ## Run the tests
	@composer test

style: vendor ## Format the application code and configuration
	@composer normalize --indent-size=4 --indent-style=space
	@composer style

lint: vendor ## Lint the codebase for formatting issues
	@composer validate
	@composer normalize --dry-run --indent-size=4 --indent-style=space --no-update-lock --no-check-lock
	@composer style -- --dry-run

vendor: composer.json composer.lock ## Install Composer vendor dependencies
	@composer install --optimize-autoloader --no-suggest --no-interaction
	@composer validate
