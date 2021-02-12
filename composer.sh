#!/bin/bash

args="$@"
command="composer $args"
echo "Running $command"
docker exec -it lumiform_assessment-app bash -c "$command"