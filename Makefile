ROOT_DIR = $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

SHELL ?= /bin/bash
ARGS = $(filter-out $@,$(MAKECMDGOALS))

IMAGE_TAG = latest
IMAGE_NAME = OlexandrRya/link-generator
BUILD_ID ?= $(shell /bin/date "+%Y%m%d-%H%M%S")

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ;              # skip prerequisite discovery

ifneq ("$(wildcard ./VERSION)","")
VERSION ?= $(shell cat ./VERSION | head -n 1)
else
VERSION ?= 0.0.1
endif

.PHONY: build
build: ## Build the Docker image
	docker build \
		--build-arg VERSION=$(VERSION) \
		--build-arg BUILD_ID=$(BUILD_ID) \
		-t $(IMAGE_NAME):$(IMAGE_TAG) \
		--no-cache \
		--force-rm .

.PHONY: up
up: ## Up container and serve
	docker compose up -d

.PHONY: serve
serve: ## Start serve
	docker-compose exec app /usr/local/bin/php /app/artisan serve --host=0.0.0.0 --port=80

.PHONY: down
down: ## Stop and kill containers
	docker-compose down

.PHONY: bash
bash: ## Exec bash inside app container
	docker-compose exec app bash

.PHONY: help
help: ## Show this help and exit (default target)
	echo ''
	printf "                     %s: \033[94m%s\033[0m \033[90m[%s] [%s]\033[0m\n" "Usage" "make" "target" "ENV_VARIABLE=ENV_VALUE ..."
	echo ''
	echo '                     Available targets:'
	# Print all commands, which have '##' comments right of it's name.
	# Commands gives from all Makefiles included in project.
	# Sorted in alphabetical order.
	echo '                     ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
	grep -hE '^[a-zA-Z. 0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | \
		 awk 'BEGIN {FS = ":.*?## " }; {printf "\033[36m%+20s\033[0m: %s\n", $$1, $$2}'
	echo '                     ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
	echo ''