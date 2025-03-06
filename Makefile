.PHONY: help build up down restart logs test init db

help:
	@echo "Comandos disponibles:"
	@echo "  make build      - Construye las imágenes Docker"
	@echo "  make up         - Levanta los contenedores en segundo plano"
	@echo "  make down       - Detiene y elimina los contenedores"
	@echo "  make restart    - Reinicia el entorno (down y up)"
	@echo "  make logs       - Muestra los logs de los contenedores"
	@echo "  make test       - Ejecuta las pruebas unitarias en el contenedor 'php'"
	@echo "  make init       - Inicializa el entorno (build, up y test)"
	@echo "  make db         - Accede al contenedor de la base de datos (MySQL)"

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

logs:
	docker-compose logs -f

test:
	docker-compose exec php ./vendor/bin/phpunit tests/

init: build up test

db:
	docker-compose exec mysql bash
