#!/bin/bash

args="$@"
command="php artisan $args"
echo "Running: $command"
docker exec -it lumiform_assessment-app bash -c "$command"

