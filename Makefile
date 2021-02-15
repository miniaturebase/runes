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
	@composer style

vendor: composer.json composer.lock ## Install Composer vendor dependencies
	@composer install --optimize-autoloader --no-suggest --no-interaction
	@composer validate
