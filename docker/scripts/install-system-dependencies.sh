#!/bin/sh

apt-get update && apt-get install -y \
    git \
    unzip \
    zip\
    libzip-dev \
    curl \
    libsqlite3-dev \
    libonig-dev \
    supervisor
