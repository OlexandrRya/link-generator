#!/bin/sh

# Exit the script if any statement returns a non-true return value
set -e

composer install --quiet --no-interaction --prefer-dist --optimize-autoloader --no-scripts
composer create-projec
composer dump-autoload -o

/usr/local/bin/php artisan cache:clear
/usr/local/bin/php artisan config:cache
/usr/local/bin/php artisan route:cache
/usr/local/bin/php artisan optimize

exec /usr/bin/supervisord -n
