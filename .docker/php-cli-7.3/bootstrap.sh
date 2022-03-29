#!/usr/bin/env bash
DOCKER_UID=${DOCKER_UID:-1001}
DOCKER_GID=${DOCKER_GID:-1001}

if [ "$DOCKER_UID" != "1001" ]; then
    groupmod --gid $DOCKER_GID docker
    usermod --uid $DOCKER_UID --gid $DOCKER_GID docker
    find /home/docker -group 1001 -exec chgrp -h docker {} \;
fi

su - docker
