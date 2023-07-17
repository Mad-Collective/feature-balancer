COMPONENT := featurebalancer
CONTAINER := phpcli
IMAGES ?= false
PHP_VERSION ?: false
APP_ROOT := /app/feature-balancer
CODE_COVERAGE_FORMAT ?= clover

all: dev logs

dev:
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml up -d --build

enter:
	@docker exec -ti ${COMPONENT}_${CONTAINER}_1 /bin/sh

kill:
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml kill

nodev:
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml kill
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml rm -f
ifeq ($(IMAGES),true)
	@docker rmi ${COMPONENT}_${CONTAINER}
endif

deps:
	@docker exec -t ${COMPONENT}_${CONTAINER}_1 php-5.5 /usr/bin/composer install

test: unit
unit:
	@docker exec -t ${COMPONENT}_${CONTAINER}_1 ${APP_ROOT}/ops/scripts/unit.sh ${PHP_VERSION}

code-coverage:
	# Wrapped because docker compose generate weird error codes. see https://github.com/docker/compose/issues/3379#issuecomment-214715606 
	@docker exec -t ${COMPONENT}_${CONTAINER}_1 sh -c 'php-7.0 ${APP_ROOT}/bin/app code-coverage:run ${CODE_COVERAGE_FORMAT}'

ps: status
status:
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml ps

logs:
	@docker-compose -p ${COMPONENT} -f ops/docker/docker-compose.yml logs

tag: # List last tag for this repo
	@git tag -l | sort -r |head -1

restart: nodev dev logs
