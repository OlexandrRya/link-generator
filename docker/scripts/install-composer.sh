#!/bin/sh

COMPOSER_PATH="/usr/bin/composer"
if [ -f "${COMPOSER_PATH}" ] ; then
  return 0
fi

EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    return 1
fi

php composer-setup.php --quiet
mv ./composer.phar ${COMPOSER_PATH}
${COMPOSER_PATH} --version
rm composer-setup.php