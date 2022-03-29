DOT_ENV = .env
include $(DOT_ENV)
ifneq ("$(wildcard .env.local)","")
	DOT_ENV = .env.local
	include $(DOT_ENV)
endif
export

IS_DOCKER := $(shell docker info > /dev/null 2>&1 && echo 1)
DOCKER_PARAM = --env-file $(DOT_ENV) -f ".docker/env/$(APP_ENV).yml"

help:
	echo "-- build: builds the docker images required to run this project"; \
	echo "-- build-force: Force rebuilds the docker images required to run this project"; \
	echo "-- start: starts the project"; \
	echo "-- restart: restarts containers"; \
	echo "-- stop: stops the project"; \
	echo "-- down: stops and removes containers used for this project (can generate data loss)"; \
	echo "-- logs: displays real time logs of containers used for this project"; \
	echo "-- purge: Delete all container and images"; \
	echo "-- ssh: enters TOOLBOX container CLI"; \
	echo "-- root-ssh: enters TOOLBOX container CLI as root"; \
	echo "-- test: run PhpUnit test suite"; \

build: do-init do-build do-finish
do-build:
	@echo "$(STEP) Building images... $(STEP)"
	docker-compose -f ".docker/env/$(APP_ENV).yml" build

build-force: do-init do-build-force do-finish
do-build-force:
	@echo "$(STEP) Building images... $(STEP)"
	docker-compose -f ".docker/env/$(APP_ENV).yml" build --no-cache

start: do-init do-start do-finish
do-start:
	@echo "$(STEP) Starting up containers... $(STEP)"
	docker-compose -f ".docker/env/$(APP_ENV).yml" up -d

stop: do-init do-stop do-finish
do-stop:
	@echo "$(STEP) Stopping containers... $(STEP)"
	docker-compose -f ".docker/env/$(APP_ENV).yml" stop

restart: do-init do-stop do-start do-finish

down: do-init do-down do-finish
do-down:
	@echo "$(STEP) Stopping and removing containers... $(STEP)"; \
	docker-compose -f ".docker/env/$(APP_ENV).yml" down;

logs: do-init do-logs do-finish
do-logs:
	@echo "$(STEP) Displaying logs... $(STEP)"; \
	docker-compose -f ".docker/env/$(APP_ENV).yml" logs -f --tail="100";

purge: do-init do-purge do-finish
do-purge:
	@echo "$(STEP) Kill all containers $(STEP)"; \
	docker kill $$(docker ps -q)
	@echo "$(STEP) Delete all containers $(STEP)"; \
	docker rm $$(docker ps -a -q)
	@echo "$(STEP) Delete all images $(STEP)"; \
	docker rmi $$(docker images -q)

setup: do-init do-setup do-finish
do-setup:
	@echo "$(STEP) Setup environment... $(STEP)"
	docker-compose -f ".docker/env/$(APP_ENV).yml" ./.script/install.sh

ssh: do-init do-ssh do-finish
do-ssh:
	@echo "$(STEP) Cli Bash $(TOOLBOX_CONTAINER_NAME)... $(STEP)"; \
	docker exec -ti -u docker $(TOOLBOX_CONTAINER_NAME) /bin/bash;

root-ssh: do-init do-root-ssh do-finish
do-root-ssh:
	@echo "$(STEP) Cli Bash $(TOOLBOX_CONTAINER_NAME)... $(STEP)"; \
	docker exec -ti $(TOOLBOX_CONTAINER_NAME) /bin/bash;

test: do-init do-test do-finish
do-test:
	@echo "$(STEP) Cli Bash $(TOOLBOX_CONTAINER_NAME)... $(STEP)"; \
	docker exec -ti -u docker $(TOOLBOX_CONTAINER_NAME) bin/phpunit -c tests/phpunit.xml;

do-init:
	@rm -f .docker-config; \
	touch .docker-config;
ifeq ($(OS),Darwin)
	@echo $$(docker-machine env default) >> .docker-config;
endif

do-finish:
	@rm -f .docker-config;
