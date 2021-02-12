args="$@"
command="vendor/bin/phpunit $args"
echo "Running: $command"
docker exec -it lumiform_assessment-app bash -c "$command"