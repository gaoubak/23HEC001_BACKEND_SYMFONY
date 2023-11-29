# 23HEC001_BACKEND_SYMFONY


# Symfony 6 + PHP 8.2 with Docker

**ONLY for DEV, not for production**

## Run Locally

Clone the project

```bash
 git@github.com:gaoubak/docker-symfony-build.git
```

Run the docker-compose

```bash
  docker compose build --no-cache --pull
```
```bash
 docker-compose up -d
```


If you dont have the folder jwt in /src/ tap : 
```bash
php bin/console lexik:jwt:generate-keypair
```
Log into the PHP container

```bash
  docker exec -it  nom-du-container bash
```

If you need a database, create a file .env.local and add a line like this example in /src:

```yaml
 DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
```

## Ready to use with

This docker-compose provides you :

- PHP-8.2-cli (Alpine)
    - Composer
    - Symfony CLI
    - pdo pdo_mysql pdo_pgsql opcache intl zip calendar dom mbstring gd xsl
    - nodejs, npm, yarn
- mercure


## Requirements

Out of the box, this docker-compose is designed for a Linux operating system, provide adaptations for a Mac or Windows environment.

- Linux (Ubuntu 20.04 or other)
- Docker
- Docker-compose
