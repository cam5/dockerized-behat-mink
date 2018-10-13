#!/bin/bash

# Runs on container boot by default!

service apache2 start;
service mysql start;

mysql -e "CREATE DATABASE ${MYSQL_USER_NAME} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
mysql -e "CREATE USER ${MYSQL_USER_NAME}@localhost IDENTIFIED BY '${MYSQL_USER_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON ${MYSQL_USER_NAME}.* TO '${MYSQL_USER_NAME}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

CMD='/bin/bash'

if [[ $1 ]]; then
  CMD=$1
fi;

# Let's assume this means CI
if [ "test" = "$CMD" ]; then
  # If it's a fresh project, supply our DB data.
  if [[ ! -f /var/www/html/app/config/parameters.yml ]]; then

    PARAMS='/var/www/html/app/config/parameters.yml'
    cp /var/www/html/app/config/parameters.yml.dist $PARAMS

    sed -i 's/root/symfony/' $PARAMS
    sed -i 's/database_password: ~/database_password: symfony/' $PARAMS
    sed -i 's/database_port: ~/database_port: 3306/' $PARAMS

    sed -i 's/mailer_user: ~/mailer_user: null/' $PARAMS
    sed -i 's/mailer_password: ~/mailer_password: null/' $PARAMS
  fi;

  # Handle dependency updates
  if [[ -f /var/www/html/composer.lock ]]; then
    composer install
  else
    if [[ -f /var/www/html/composer.json ]]; then
      composer update
    fi;
  fi;

  php bin/console doctrine:schema:update --force
  /var/www/html/vendor/bin/behat --tags ~@javascript
fi;

$CMD
