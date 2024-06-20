define default
$(if $(1),$(1),$(2))
endef

up:
	@touch .backend/extra/history
	@docker compose ${up-as} up $(call default,${up-with},-d)

down:
	@docker compose down ${down-with}

restart:
	@docker compose restart ${service}

build:
	@touch .backend/extra/history
	${MAKE} up up-with="--build -d"

destroy:
	${MAKE} down down-with="--volumes"

shell:
	@docker compose exec $(call default,${service},backend) $(call default,${run},bash)

logs:
	@docker compose logs ${service}

logs.follow:
	@docker compose logs -f ${service}

ps:
	@docker compose ps

status: ps

test:
	${MAKE} shell run="composer test"