#!/bin/bash

docker build -t pp-gql ../.
docker run --rm -it -v ${PWD}/../:/var/www/html "$@" pp-gql
