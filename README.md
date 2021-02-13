# Lumiform - IMDB API 

## Project setup

```
Setup Environment variables (see section below)
```

### Environment Variables
To setup the environment variables used by docker, please follow these steps
- You need to copy .env_sample and rename as .env
- set the values of these variables.

| Name                              | Description                               |
| ----------------------------------|-------------------------------------------|
| `DB_DATABASE`                     | Name of Database                          |
| `DB_PASSWORD`                     | Database password                         |
| `DB_USERNAME`                     | Database username                         |
| `DB_CONTAINER`                    | Name of database container               |
| `APP_CONTAINER`                   | Name of app container                        |
| `ADMINER_CONTAINER`               | Name of adminer container                        |
| `WEBSERVER_CONTAINER`             | Name of webserver container                               |


### Start Docker

```
 run command: docker-compose up -d
```

### Setup helper bash scripts
I have added bash scripts to reduce key strokes when executing usual tasks.
To make them executable, you need to make them executable
Copy the value of APP_CONTAINER set in .env file and replace it with "lumiform_assessment-app" in bash scripts

- chmod +x php-artisan.sh
- chmod +x composer.sh
- chmod +x container.sh
- chmod +x php-unit.sh

```
- container.sh: For runing commands in the container
- composer.sh: For running composer commands
- php-artisan.sh: For running php artisan commands
- php-unit.sh: For running php unit test
```

### Install composer dependencies

```
Run: ./composer.sh install
```

### Run unit tests
You can use either php-unit.sh or php-artisan.sh to run tests
```
 Using PhpUnit, Run: ./php-unit.sh
 Using Laravel Artisan, Run: ./php-artisan.sh test 
```

### To exec into the container working directory, run 

```
 ./container.sh
```

### To see list of php artisan commands, run 

```
 ./php-artisan.sh 
```
