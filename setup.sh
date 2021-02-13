#!/bin/bash

docker exec -it lumiform_assessment-app bash -c "composer install"
docker exec -it lumiform_assessment-app bash -c "php artisan key:generate"
docker exec -it lumiform_assessment-app bash -c "php artisan migrate"
docker exec -it lumiform_assessment-app bash -c "php artisan passport:install --force"

