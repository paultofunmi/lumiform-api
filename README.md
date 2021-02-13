# Lumiform - IMDB API 

### Environment Docker Variables
To setup the environment variables used by docker, please follow these steps

```
- You need to copy .env_sample and rename as .env
- Set the values of these variables or use the default in the sample file
- If you are changing these values, you need to copy the value set 
for APP_CONTAINER, replacing the new value with lumiform_assessment-app 
in bash scripts
```

| Name                              | Description                               |
| ----------------------------------|-------------------------------------------|
| `DB_DATABASE`                     | Name of Database                          |
| `DB_PASSWORD`                     | Database password                         |
| `DB_USERNAME`                     | Database username                         |
| `DB_CONTAINER`                    | Name of database container                |
| `APP_CONTAINER`                   | Name of app container                     |
| `ADMINER_CONTAINER`               | Name of adminer container                 |
| `WEBSERVER_CONTAINER`             | Name of webserver container               |


### Start Docker

```
 docker-compose up -d
```

### Setup helper bash scripts
- I have added bash scripts to reduce key strokes when executing usual tasks.
- Ensure that the value of APP_CONTAINER set in .env file is the same in bash scripts.
- To do so, you need to replace "lumiform_assessment-app" with value you set for APP_CONTAINER 
- To make bash scripts executable, you need to run these commands

```
chmod +x php-artisan.sh
chmod +x composer.sh
chmod +x container.sh
chmod +x php-unit.sh
chmod +x setup.sh
```

```
container.sh: takes you into container
composer.sh: For running composer commands
php-artisan.sh: For running php artisan commands
php-unit.sh: For running php unit test
setup.sh: This script installs composer dependencies, migrates the db, set up encryption key and setup laravel's passport
```

### Setup laravel
- In the www directory, cp .env.example and rename as .env
- Set the values of the following; DB_DATABASE, DB_USERNAME and DB_PASSWORD to what you set in you docker env variables
- Set the value of DB_HOST to db.
- Run the setup bash script (it installs composer dependencies, migrate db and setup laravel passort)
```
./setup.sh
```

### Setup API Keys for OMDB
You need to set your api keys 
```
OMDB_APIKEY=
OMDB_BASEURL=
```

### Install composer commands

```
./composer.sh <your_composer_command>
```

### To exec into the container working directory, run

```
 ./container.sh
```


### Run unit tests
You can use either php-unit.sh or php-artisan.sh to run tests
```
 Using PhpUnit:
  
 ./php-unit.sh
 
 Using Laravel Artisan, 
 
 ./php-artisan.sh test 
```


### To see list of php artisan commands, run 

```
 ./php-artisan.sh 
```
