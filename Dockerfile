FROM php:8.2-fpm

WORKDIR /app

COPY . /app

RUN bash /app/docker/scripts/install-composer.sh
RUN bash /app/docker/scripts/install-system-dependencies.sh
RUN bash /app/docker/scripts/install-php-dependencies.sh

EXPOSE 80

CMD ["/app/docker/scripts/post-build-commands.sh"]