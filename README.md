# Proyecto Dockerizado con PHP y MySQL

Este proyecto proporciona un entorno de desarrollo con PHP, MySQL y Docker para facilitar la gestión y ejecución de la aplicación.

## Requisitos

Antes de comenzar, asegúrate de tener instalado lo siguiente:
* Docker
* Docker Compose
* Make (Opcional)

## Instalación

Clona este repositorio y accede al directorio del proyecto:

```sh
git clone https://github.com/jorgmendoz/docfac.git
cd docfac
```

## Comandos disponibles

Para facilitar la gestión del entorno, se incluye un Makefile con los siguientes comandos:

```sh
make help       # Para ayuda
make build      # Construye las imágenes Docker
make up         # Levanta los contenedores en segundo plano
make down       # Detiene y elimina los contenedores
make restart    # Reinicia el entorno (down y up)
make logs       # Muestra los logs de los contenedores
make test       # Ejecuta las pruebas unitarias en el contenedor PHP
make init       # Inicializa el entorno (build, up y test)
make db         # Accede al contenedor de la base de datos
```

## Levantar el entorno

Ejecuta el siguiente comando para construir y ejecutar los contenedores en segundo plano:

```sh
make init
```

## Acceder a la base de datos

Para conectarte al contenedor de MySQL y ejecutar consultas:

```sh
make db
```

Dentro del contenedor puedes acceder a MySQL con:

```sh
mysql -u$$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE
```

## Ejecutar pruebas

Si el proyecto incluye pruebas unitarias con PHPUnit, puedes ejecutarlas con:

```sh
make test
```

## Para testear la solicitud HTTP y llamar al caso de uso

Puedes copiar y pegar el siguiente curl

```sh
curl -X POST http://localhost:8000/register \
	-H "Content-Type: application/json" \
	-d '{"name": "Jorge Mendoza", "email": "jorgmendoz@gmail.com", "password": "Password@123"}'
```